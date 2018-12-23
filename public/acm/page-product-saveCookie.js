

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
    let userCart = getCookie('userCart');
    if(userCart.length>0) {
        return JSON.parse(userCart);
    } else {
        return [];
    }
}

function addToCartInCookie() {

    let userCart = getUserCartFromCookie();

    let data = {
        'productId':  'product-id' ,
        'simpleInfoAttributes':  'simpleInfoAttributes-toJson()' ,
        'checkboxInfoAttributes':  'checkboxInfoAttributes-toJson()'
    };

    let dataId = data.product.id;


    let userHaveThisProduct = false;
    for (var index in userCart) {
        if(userCart[index].product.id == dataId) {
            userHaveThisProduct = true;
        } else {
            userHaveThisProduct = false;
        }
    }

    if(!userHaveThisProduct) {
        userCart.push(data);
    }

    setCookie('userCart', JSON.stringify(userCart), 7);

    console.log('UserCartFromCookie: ', getUserCartFromCookie());
}

