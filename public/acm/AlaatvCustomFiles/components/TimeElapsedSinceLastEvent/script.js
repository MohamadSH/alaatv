var TimeElapsedSinceLastEvent = function () {

    function setEventOccurrenceTime(key) {
        localStorage.setItem(key, Date.now().toString());
    }

    function getLastEventTime(key) {
        return localStorage.getItem(key);
    }

    function getTimeElapsedSinceLastEvent(key) {
        var lastEventTime = getLastEventTime(key),
            diffTime = Date.now() - lastEventTime;
        return diffTime;
    }

    function canBrowserSupportLocalStorage() {
        return typeof(Storage) !== "undefined";
    }

    function get(key) {
        if (typeof key === 'undefined' || key === null || key.trim().length === 0) {
            console.error('TimeElapsedSinceLastEvent: Key not specified!');
            return null;
        }
        if (!canBrowserSupportLocalStorage()) {
            console.error('TimeElapsedSinceLastEvent: The browser does not support the Local Storage!');
            return null;
        }

        return getTimeElapsedSinceLastEvent(key);
    }

    return {
        get: get,
        setEventOccurrenceTime: setEventOccurrenceTime,
        canBrowserSupportLocalStorage: canBrowserSupportLocalStorage
    };
}();

