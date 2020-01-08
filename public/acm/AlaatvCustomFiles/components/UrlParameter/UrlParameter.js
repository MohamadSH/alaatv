var UrlParameter = function() {

    function getUrlData() {
        return document.location.href.split('?');
    }

    function setParams(paramsString, pushHistory) {
        var urlData = getUrlData(),
            url = urlData[0];
        if (paramsString.length > 0) {
            url += '?' + paramsString;
        }
        setState(url , pushHistory);
    }

    function setState(url, pushHistory) {
        if (typeof pushHistory !== 'undefined') {
            window.history.pushState('data to be passed', 'Title of the page', url);
        } else {
            pushHistory = {}; //data to be passed
        }
        // The above will add a new entry to the history so you can press Back button to go to the previous state.
        // To change the URL in place without adding a new entry to history use
        history.replaceState(pushHistory, 'Title of the page', url);
    }

    function getParams() {
        var urlData = getUrlData(),
            params = (typeof urlData[1] !== 'undefined') ? urlData[1].split('&') : [],
            newParams = {},
            paramsLength = params.length;
        for (var i = 0; i < paramsLength; i++) {
            var itemData = params[i].split('=');
            if (itemData[0].length > 0) {
                newParams[itemData[0]]  = itemData[1];
            }
        }
        return newParams;
    }

    function getParam(key) {
        var params = getParams();
        for (var paramKey in params) {
            if (String(key) === String(paramKey) && paramKey.length > 0) {
                return params[paramKey];
            }
        }
        return null;
    }

    function setParam(key, value, pushHistory) {
        var params = getParams(),
            paramsString = '',
            existItem = null;
        for (var paramKey in params) {
            if (String(key) === String(paramKey) && paramKey.length > 0) {
                existItem = paramKey + '=' + value;
            }
            if (existItem !== null && existItem !== '') {
                paramsString += existItem + '&';
                existItem = '';
            } else {
                paramsString += paramKey + '=' + value + '&';
            }
        }

        if (existItem === null) {
            paramsString += key + '=' + value;
        } else {
            paramsString = paramsString.substring(0, paramsString.length - 1);
        }

        setParams(paramsString, pushHistory);
    }

    return {
        getParams: getParams,
        getParam: getParam,
        setParam: setParam,
        setState: setState
    }

}();
