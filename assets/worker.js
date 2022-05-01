import { createApp } from "vue/dist/vue.esm-bundler"

var productBuffer = []

const App = createApp({
    data() {
        return {
            catPopularId: -1,
            products: null,
            activeCategory: null,
            hidCatVisibility: false,
            card: [
                // {
                //    id: int,
                //    quantity: int,
                //    configuratorItemIds: array of Ids
                // },
            ],
            cardBadgeText: 0,
            productModalData: {}
        }
    },
    delimiters: ['${', '}$'],
    beforeMount() {
        this.getProductDataByCategory(this.catPopularId)
    },
    methods: {
        getProductDataByCategory(catId) {
            this.activeCategory = catId
            this.products = null
            var self = this
            $.ajax({
                url: "/get-product-data",
                data: {
                    category_id: catId
                },
                dataType: 'json'
            }).done(function( res ) {
                // console.log (res)
                res.forEach( (item) => {
                    productBuffer[item.id] = item
                })
                self.products = res
            })
        },
        trigHidCatVis() {
            this.hidCatVisibility = !this.hidCatVisibility
        },
        // предусмотрены ли для продукта конфигураторы
        hasConfigurators(id) {
            return productBuffer[id].configurators.length !== 0
        },
        addToCard(id, event) {
            try {
                // (клик по кнопке на сайте) если для продукта предусмотрены конфигураторы, отправляем в мод. окно
                if ( $(event.target).hasClass('site-add-to-card-btn') ) {
                    if ( this.hasConfigurators(id) ) {
                        this.showProductModal(id)
                        throw 'Go to Modal'
                    }
                }
                // выбранные ингредиенты для текущего продукта (перечисляются их ids)
                let configuratorItemIds = []
                if ( this.hasConfigurators(id) ) {
                    // проверка на выбор ингредиентов в обязательных группах
                    $('.configurator-required').each((i, conf) => {
                        if ( $(conf).find("input:checked").length === 0 ) {
                            alert ("В группах со звездочками необходимо указать ингредиенты")
                            throw 'Incorrect Configurators'
                        }
                    })
                    // выбираем каждый выделенный ингредиент конфигуратора
                    $('.configurator').find("input:checked").each((i, confItem) => {
                        configuratorItemIds.push( $(confItem).data('id') )
                    })
                }

                let cardItem = this.getCardItem(id, configuratorItemIds)
                if ( !cardItem ) {
                    // добавляем в корзину продукты
                    // отдельно сконфигурированный продукт добавляется отдельно
                    this.card.push({
                        id: id,
                        quantity: 1,
                        configuratorItemIds: configuratorItemIds
                    })
                } else {
                    cardItem.quantity++
                }
                // console.log (this.card)
            }
            catch (e) {
                // console.log (e)
            }
        },
        addToCardDirectly(cardIndex) {
            this.card[cardIndex].quantity++
            // console.log (this.card)
        },
        removeFromCard(id) {
            // удаляем последний добавленный продукт
            let cardItem = this.getCardItem(id)
            if ( cardItem.quantity === 1 ) {
                this.card = this.card.filter(item => {
                    return JSON.stringify(item) !== JSON.stringify(cardItem)
                })
            } else {
                cardItem.quantity--
            }
            // console.log (this.card)
        },
        removeFromCardDirectly(cardIndex) {
            if ( this.card[cardIndex].quantity === 1 )
                this.card.splice(cardIndex, 1)
            else
                this.card[cardIndex].quantity--
            // console.log (this.card)
        },
        getCardItem(id, curConfItemIds) {
            if (curConfItemIds) {
                return this.card.find(el =>
                    el.id === id && JSON.stringify(el.configuratorItemIds) === JSON.stringify(curConfItemIds)
                )
            } else {
                let lastElem = null
                // в корзине может быть несколько продуктов с одинаковым id, выбираем последний из них
                this.card.forEach((el) => {
                    if (el.id === id) lastElem = el
                })
                return lastElem
            }
        },
        getCardProductQuantity(id) {
            let allQuant = 0
            this.card.forEach((element) => {
                if ( element.id === id ) {
                    allQuant = allQuant + element.quantity
                }
            })
            return allQuant
        },
        getCardBadgeText() {
            let price = 0
            this.card.forEach(cardProduct => {
                price = price + (productBuffer[cardProduct.id].price_main * cardProduct.quantity)
                cardProduct.configuratorItemIds.forEach(confItemId => {
                    price = price + (this.getConfiguratorItemFromBuffer(confItemId).price * cardProduct.quantity)
                })
            })
            this.cardBadgeText = price
            return price ? price + " руб." : 0
        },
        // получает объект ConfiguratorItem из ProductBuffer
        getConfiguratorItemFromBuffer(confItemId) {
            let returnItem = null
            productBuffer.forEach(product => {
                product.configurators.forEach(configurator => {
                    configurator.items.forEach(item => {
                        if (item.id === confItemId) {
                            returnItem = item
                        }
                    })
                })
            })
            return returnItem
        },
        getProductNameByIdFromBuffer(id) {
            return productBuffer[id].name
        },
        getFullPriceByIndexFromBuffer(index) {
            let productId = this.card[index].id
            let productPrice = productBuffer[productId].price_main
            let confItemsPrice = 0
            let self = this
            this.card[index].configuratorItemIds.forEach(confId => {
                confItemsPrice = confItemsPrice + self.getConfiguratorItemFromBuffer(confId).price
            })
            return (productPrice + confItemsPrice) * this.card[index].quantity
        },
        getConfItemDescByIdFromBuffer(id) {
            let confItem = this.getConfiguratorItemFromBuffer(id)
            return confItem.name + ' - ' + confItem.price + ' руб.'
        },
        // открытие карточки товара
        showProductModal(id) {
            this.productModalData = productBuffer[id]
            $('#product-modal').modal('show')
            $.ajax({
                url: "/get-product-modal",
                data: { id: id },
                beforeSend() {
                    $('#product-modal .modal-body').html('<img src="/public/catalog-loading.svg">')
                }
            }).done(function( res ) {
                $('#product-modal .modal-body').html(res)
            })
        },
        // закрытие карточки товара
        closeProductModal() {
            $('#product-modal').modal('hide')
        },
        getOrderLink() {
            let cardParams = encodeURIComponent(JSON.stringify(this.card))
            return '/order?data=' + cardParams
        }
    }
})
App.mount('#app')

// инициализация slick carousel
$(document).ready(function(){
    $('.main-slider').slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        autoplay: true,
        autoplaySpeed: 3000,
    })
})

// отключение figcaption-description на малой ширине изображения
$('.products').on('mouseover', '.product-image', function() {
    if ( $(this).width() < 250 ) {
        $(this).find('.figcaption-desc').hide()
    } else {
        $(this).find('.figcaption-desc').show()
    }
})

// отображение корзины
$('.show-card').on('click', function() {
    $('#card-modal').modal('show')
})
// скрытие корзины
$('.card-modal-close').on('click', function() {
    $('#card-modal').modal('hide')
})