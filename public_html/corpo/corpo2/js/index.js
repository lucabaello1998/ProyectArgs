const ROUTER = new Router(PATHS);

//windows refresh back home
window.onbeforeunload = function() {
    ROUTER.load('home');
}