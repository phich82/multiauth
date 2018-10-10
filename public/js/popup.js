var popup = {
    selector: '.popup',
    events: {yes: null, no: null},
    id: function (idName) {
        return this.setIdentity('#'+idName);
    },
    class: function (className) {
        return this.setIdentity('.'+className);
    },
    identity: function (identity) {
        return this.setIdentity(identity);
    },
    setIdentity: function (identity) {
        this.selector = identity;
        return this;
    },
    element: function () {
        if (!document.querySelector(this.selector)) {
            throw new Error('No any elements contains identity ['+this.identity+'].');
        }
        return document.querySelector(this.selector);
    },
    close: function () {
        this.element().style.display = 'none';
    },
    open: function () {
        this.element().style.display = 'block';
    },
	confirm: function () {
        var title   = '';
        var message = '';
        var yes = null;
        var no  = null;
        var buttons = null;

        switch (arguments.length) {
            case 2:
                if (typeof arguments[0] !== 'function' || typeof arguments[1] !== 'function') {
                    throw new Error('Two arguments[1, 2] should be a function');
                }
                yes = arguments[0];
                no  = arguments[1];
                break;
            case 4:
                if (typeof arguments[2] !== 'function' || typeof arguments[3] !== 'function') {
                    throw new Error('Two arguments[2, 3] should be a function');
                }
                title   = arguments[0];
                message = arguments[1];
                yes     = arguments[2];
                no      = arguments[3];
                break;
            case 5:
                if (typeof arguments[3] !== 'function' || typeof arguments[4] !== 'function') {
                    throw new Error('Two arguments[3, 4] should be a function');
                }
                title   = arguments[0];
                message = arguments[1];
                buttons = arguments[2];
                yes     = arguments[3];
                no      = arguments[4];
                break;
            default:
                throw new Error('Only accepted 2 or 4 arguments.');

        }
        this.element().querySelector('.modal-title').innerHTML   = title;
        this.element().querySelector('.modal-message').innerHTML = message;
        if (buttons && typeof buttons === 'object') {
            if (buttons.ok) {
                this.element().querySelector('.btnSaveModal').innerHTML   = buttons.ok;
            }
            if (buttons.cancel) {
                this.element().querySelector('.btnCancelModal').innerHTML = buttons.cancel;
            }
        }
        this.open();
        this.events.yes = yes;
        this.events.no  = no;
    },
    yes: function(element) {
        if (typeof this.events.yes === 'function') {
            this.events.yes.call(null, element);
            this.close();
        }
    },
    no: function(element) {
        if (typeof this.events.no === 'function') {
            this.events.no.call(null, element);
            this.close();
        }
    },
    closest: function (elem, selector) {
        var firstChar = selector.charAt(0);
        // Get closest match
        for (; elem && elem !== document; elem = elem.parentNode) {
            // If selector is a class
            if (firstChar === '.' && elem.classList.contains(selector.substr(1))) { return elem; }
            // If selector is an ID
            if (firstChar === '#' && elem.id === selector.substr(1)) { return elem; }
            // If selector is a data attribute
            if (firstChar === '[' && elem.hasAttribute(selector.substr(1, selector.length - 2))) { return elem; }
            // If selector is a tag
            if (elem.tagName.toLowerCase() === selector) { return elem; }
        }
        return null;
    }
};
