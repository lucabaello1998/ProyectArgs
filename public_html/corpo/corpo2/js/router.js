class Router {
    constructor(paths) {
        this.paths = paths;
    }
    initRouter() {
        const {
            location: { pathname = '/' }
        } = window;
        const URL = pathname === '/' ? 'home' : pathname.replace('/', '');
        this.load(URL);
    }
    load(page = 'home') {
        const { paths } = this;
        const { path, template } = paths[page] || paths.error;
        const $CONTAINER = document.querySelector("#content");
        $CONTAINER.innerHTML = template;
        window.history.pushState({}, "done", path);
    }
    refresh(page = 'home') {
        const { paths } = this;
        const { path, template } = paths[page] || paths.error;
        const $CONTAINER = document.querySelector("#content");
        $CONTAINER.innerHTML = template;
        window.history.replaceState({}, "done", path);
    }
}