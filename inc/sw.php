<script>
const dom = document.getElementById('swUpdateNotice');
if ('serviceWorker' in navigator) {
    dom.addEventListener('click', () => {
    try {
        dom.style.display = 'none';
        window.location.reload();
        navigator.serviceWorker.getRegistration().then(reg => {
        reg.waiting.postMessage("skipWaiting");
        });
    } catch (e) {
        window.location.reload();
    }
    })

    function showSWUpdateNotice() {
    if (dom) {
        dom.style.display = 'inline-block';
    }
    }

    window.addEventListener('load', function() {
    // 防止爬虫在抓抓取的时候 sw 注册失败产生错误
    if (location.protocol !== 'https:' &&
        (location.hostname !== '127.0.0.1' && location.hostname !== 'localhost')) {
        return false;
    }
    //  todo 这是有问题的
    const isLogin = (<?php echo is_user_logged_in() ? 'true' : 'false' ;?>);
    const serviceWorker = navigator.serviceWorker;

    serviceWorker.register('/wp-json/wp_theme_pure/v1/service-worker.js', {scope: '/'})
        .then(function(registration) {
            // console.log('ServiceWorker registration successful with scope: ', registration.scope);
            if (isLogin) {
            registration.unregister().then(function (flag) {
                console.log('user is login, ServiceWorker unregister ' + (flag ? 'success' : 'fail'));
            });
            }

            // if (registration.waiting) {
            //   showSWUpdateNotice();
            //   return;
            // }

            // need update
            registration.addEventListener('updatefound', () => {
            const newWorker = registration.installing;

            newWorker.addEventListener('statechange', () => {
                if (newWorker.state === 'installed') {
                if (navigator.serviceWorker.controller) {
                    showSWUpdateNotice();
                }
                }
            });
        });
        }).catch(function(err) {
            console.log('ServiceWorker registration failed: ', err);
        });

    serviceWorker.addEventListener('controllerchange', function () {
        showSWUpdateNotice();
    });
    });
}
</script>