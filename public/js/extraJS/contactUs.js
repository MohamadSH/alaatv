var Contact = function () {

    return {
        //main function to initiate the module
        init: function () {
            var map;
            $(document).ready(function(){
                map = new GMaps({
                    div: '#gmapbg',
                    lat: +35.7047661,
                    lng: +51.3497245,
                    zoom:17
                });
                var marker = map.addMarker({
                    lat: +35.705180,
                    lng: +51.350293,
                    title: 'دبیرستان دانشگاه صنعتی شریف',
                    infoWindow: {
                        content: "<br><b>دبیرستان دانشگاه صنعتی شریف</b> تهران، خ آزادی ، خ حبیب اللهی<br>خ قاسمی ، نبش کوچه گلستان، پلاک ۵۹"
                    }
                });

                marker.infoWindow.open(map, marker);
            });
        }
    };

}();

jQuery(document).ready(function() {
    Contact.init();
});