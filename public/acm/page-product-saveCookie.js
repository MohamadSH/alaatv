




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
        let userCart = getCookie('UserCart');
        if(userCart.length>0) {
            return JSON.parse(userCart);
        } else {
            return [];
        }
    }
    function addToCartInCookie(data) {

        let userCart = getUserCartFromCookie();

        // let data = {
        //     'product_id':productId,
        //     'mainAttributeStates':mainAttributeStates,
        //     'extraAttributeStates':extraAttributeStates,
        //     'productSelectValues':productSelectValues,
        // };



        let userHaveThisProduct = false;
        for (var index in userCart) {
            if(userCart[index].product_id == data.product_id) {
                userHaveThisProduct = true;
                userCart[index] = data;
            } else {
                userHaveThisProduct = false;
            }
        }

        if(!userHaveThisProduct) {
            userCart.push(data);
        }

        setCookie('UserCart', JSON.stringify(userCart), 7);

        console.log('UserCartFromCookie: ', getUserCartFromCookie());
    }

    return {
        addToCartInCookie: function (data) {
            addToCartInCookie(data);
        }
    };
}();

jQuery(document).ready(function() {

    $(document).on('click', ".btnAddToCart", function() {

        let mainAttributeStates = getMainAttributeStates();
        let extraAttributeStates = getExtraAttributeStates();
        let productSelectValues = getProductSelectValues() ;

        let data = {
            'product_id':$('input[name="product_id"][type="hidden"]').val(),
            'mainAttributeStates':mainAttributeStates,
            'extraAttributeStates':extraAttributeStates,
            'productSelectValues':productSelectValues,
        };

        UesrCart.addToCartInCookie(data)

        //
        //
        // console.log({
        //     'product_id':$('input[name="product_id"][type="hidden"]').val(),
        //     'mainAttributeStates':mainAttributeStates,
        //     'extraAttributeStates':extraAttributeStates,
        //     'productSelectValues':productSelectValues,
        // })

    });
});

