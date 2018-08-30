(function () {



    window.addEventListener('resize', function () {

    });


    function isInSight(el) {
        if (!el) {
            return false;
        }


    }


    function getOffset (el) {
        let info = {
            top: 0,
            left: 0,
            right: 0,
            bottom: 0,
        };

        const dict = {
            top: 'offsetTop',
            right: 'offsetRight',
            left: 'offsetLeft',
            bottom: 'offsetBottom'
        };


        let target = el;

        while(target) {
            
    

            target = el.parentElement;
        }
    }




    class LazyLoad {
        constructor(selector) {
            
        };
    }
})();