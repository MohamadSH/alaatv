var UesrCart = function () {

    function setCookie(cname, cvalue, exdays) {
        var d = new Date();
        d.setTime(d.getTime() + (exdays*24*60*60*1000));
        var expires = "expires="+ d.toUTCString();
        document.cookie = cname + "=" + cvalue + ";" + expires + ";path=/";
    }

    function getCookie(cname) {
        var name = cname + "=";
        var decodedCookie = decodeURIComponent(document.cookie);
        var ca = decodedCookie.split(';');
        for(var i = 0; i <ca.length; i++) {
            var c = ca[i];
            while (c.charAt(0) == ' ') {
                c = c.substring(1);
            }
            if (c.indexOf(name) == 0) {
                return c.substring(name.length, c.length);
            }
        }
        return "";
    }

    function getUserCartFromCookie() {
        let userCart = getCookie('cartItems');
        if(userCart.length>0) {
            return JSON.parse(userCart);
        } else {
            return [];
        }
    }

    function addToCartInCookie(data) {

        let userCart = getUserCartFromCookie();

        let userHaveThisProduct = false;
        for (let index in userCart) {
            if(parseInt(userCart[index].product_id) === parseInt(data.product_id)) {
                userHaveThisProduct = true;
                userCart[index] = data;
            }
        }

        if(!userHaveThisProduct) {
            userCart.push(data);
        }

        setCookie('cartItems', JSON.stringify(userCart), 7);
    }

    function removeFromCartInCookie(data) {

        let userCart = getUserCartFromCookie();

        let userHaveThisProduct = false;
        for (let index in userCart) {
            if(parseInt(userCart[index].product_id) === parseInt(data.simpleProductId)) {
                userHaveThisProduct = true;
                userCart.splice(index, 1);
            }
             else {
                for (let selectedProductsIndex in userCart[index].products) {
                    if(parseInt(userCart[index].products[selectedProductsIndex]) === parseInt(data.simpleProductId)) {
                        userHaveThisProduct = true;
                        userCart[index].products.splice(selectedProductsIndex, 1);
                        if (userCart[index].products.length === 0) {
                            userCart.splice(index, 1);
                        }
                    }
                }
            }
        }

        setCookie('cartItems', JSON.stringify(userCart), 7);
    }

    function increaseOneProductNumber() {
        let shoppingBasketOfUserNumber = $('.shoppingBasketOfUserNumber');
        if (shoppingBasketOfUserNumber.length === 0) {
            return 0;
        }
        let number = parseInt(shoppingBasketOfUserNumber.html());
        shoppingBasketOfUserNumber.html((++number));
    }

    function reduceOneProductNumber() {
        let shoppingBasketOfUserNumber = $('.shoppingBasketOfUserNumber');
        if (shoppingBasketOfUserNumber.length === 0) {
            return 0;
        }
        let number = parseInt(shoppingBasketOfUserNumber.html());
        shoppingBasketOfUserNumber.html((--number));
    }

    return {
        addToCartInCookie: function (data) {
            addToCartInCookie(data);
        },
        removeFromCartInCookie: function (data) {
            removeFromCartInCookie(data);
        },
        increaseOneProductNumber: function () {
            increaseOneProductNumber();
        },
        reduceOneProductNumber: function () {
            reduceOneProductNumber();
        },
    };
}();
