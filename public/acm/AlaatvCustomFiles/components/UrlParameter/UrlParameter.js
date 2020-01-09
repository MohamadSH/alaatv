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
            window.history.pushState(pushHistory, 'Title of the page', url);
        } else {
            window.history.replaceState({}, 'Title of the page', url);
        }
        // The above will add a new entry to the history so you can press Back button to go to the previous state.
        // To change the URL in place without adding a new entry to history use
    }

    function getParams() {
        var urlData = getUrlData(),
            params = (typeof urlData[1] !== 'undefined') ? urlData[1].split('&') : [],
            newParams = {},
            paramsLength = params.length,
            arrayParamCounter = 0;
        for (var i = 0; i < paramsLength; i++) {
            var itemData = params[i].split('=');
            if (itemData[0].length > 0) {
                if (checkParamKeyIsArray(itemData[0])) {
                    itemData[0] = setArrayParamKey(itemData[0], arrayParamCounter);
                    arrayParamCounter++;
                }
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

    function getArrayParam(key) {
        var params = getParams(),
            arrayParam = {};
        for (var paramKey in params) {
            if (paramKey.length > 0 && checkParamKeyIsArray(paramKey)&& String(getNameOfArrayParam(key)) === String(getNameOfArrayParam(paramKey))) {
                arrayParam[paramKey] = params[paramKey];
            }
        }

        return arrayParam;
    }

    function setParam(key, value, pushHistory) {

        var params = getParams(),
            paramsString = '',
            existItem = null,
            existArrayItem = null;

        if (checkParamKeyIsArray(key)) {
            var arrayParams = getArrayParam(key),
                arrayParamsKeys = Object.keys(arrayParams);
            existArrayItem = getNameOfArrayParam(key) + '[' + arrayParamsKeys.length + ']=' + value;
        }

        for (var paramKey in params) {
            if (paramKey.length > 0 && String(key) === String(paramKey) && existArrayItem === null) {
                existItem = paramKey + '=' + value;
            }
            if (existItem !== null && existItem !== '') {
                paramsString += existItem + '&';
                existItem = '';
            } else {
                paramsString += paramKey + '=' + params[paramKey] + '&';
            }
        }

        if (existItem === null) {
            if (existArrayItem !== null) {
                paramsString += existArrayItem;
            } else {
                paramsString += key + '=' + value;
            }
        } else {
            paramsString = paramsString.substring(0, paramsString.length - 1);
        }

        setParams(paramsString, pushHistory);
    }

    function getNameOfArrayParam(paramKey) {
        return paramKey.replace(/\[.*\]/g, '');
    }

    function setArrayParamKey(paramKey, index) {
        return getNameOfArrayParam(paramKey) + '[' + index + ']';
    }

    function checkParamKeyIsArray(paramKey) {
        return RegExp('^.*\\[.*\\]$').test(paramKey);
    }

    function clearAllParams(pushHistory) {
        var urlData = getUrlData(),
            url = urlData[0];
        setState(url , pushHistory);
    }

    function getHash() {
        return window.location.hash.replace('#', '');
    }

    function removeHash(url) {
        return url.replace(window.location.hash, '');
    }

    function setHash(state, pushHistory) {
        setState(removeHash(window.location.href + '#' + state), pushHistory);
    }

    return {
        getUrlData: getUrlData,
        getParams: getParams,
        getArrayParam: getArrayParam,
        getParam: getParam,
        clearAllParams: clearAllParams,
        setParams: setParams,
        setParam: setParam,
        setState: setState,
        getHash: getHash,
        setHash: setHash,
    }

}();
