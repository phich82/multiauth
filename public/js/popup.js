const popup = {
    selector: '.popup',
    classMultipleFooter: '.modal-footer-multiple',
    classSingleFooter: '.modal-footer-single',
    classTitle: '.modal-title',
    classMessage: '.modal-message',
    classSaveButton: '.btnSaveModal',
    classCancelButton: '.btnCancelModal',
    classCloseButton: '.btnCloseModal',
    valueShowDisplay: 'block',
    valueHideDisplay: 'none',
    isWaiting: false,
    events: {yes: null, no: null},
    typeMessage: null,
    _config: null,
    id: function (id) {
        return this.setIdentity('#'+id);
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
    wait: function () {
        this.isWaiting = true;
        return this;
    },
    config: function (config) {
        this._config = config;
        return this;
    },
    setConfig: function () {
        if (this._config && typeof this._config === 'object') {
            this.setHtml(this.classTitle, this.getIcon(this._config.type || this.typeMessage)+this._config.title);
            this.setHtml(this.classMessage, this._config.message);
            if (this._config.buttons) {
                this.setHtml(this.classSaveButton, this._config.buttons.ok);
                this.setHtml(this.classCancelButton, this._config.buttons.no);
                this.setHtml(this.classCloseButton, this._config.buttons.close);
            }
        }
    },
    setDisplayAttr: function (identity, value) {
        if (value === undefined) {
            this.element().style.display = identity;
        } else {
            this.element().querySelector(identity).style.display = value;
        }
    },
    setButtons: function (isMultiple) {
        isMultiple = typeof isMultiple === 'boolean' ? isMultiple : true;
        this.setDisplayAttr(this.classMultipleFooter, isMultiple ? this.valueShowDisplay : this.valueHideDisplay);
        this.setDisplayAttr(this.classSingleFooter, isMultiple ? this.valueHideDisplay : this.valueShowDisplay);
    },
    setHtml: function (identity, html) {
        if (identity && html !== undefined) {
            this.element().querySelector(identity).innerHTML = html;
        }
    },
    getIcon: function (type) {
        var icon;
        switch (type) {
            case 'success':
                icon = '<i class="glyphicon glyphicon-ok text-success" style="font-size: 24px;"></i>';
                break;
            case 'error':
                icon = '<i class="glyphicon glyphicon-remove-sign text-danger" style="font-size: 24px;"></i>';
                break;
            case 'warning':
                icon = '<i class="glyphicon glyphicon-warning-sign text-warning" style="font-size: 24px;"></i>';
                break;
            case 'info':
                icon = '<i class="glyphicon glyphicon-info-sign text-info" style="font-size: 24px;"></i>';
                break;
            case 'confirm':
                icon = '<i class="glyphicon glyphicon-question-sign text-primary" style="font-size: 24px;"></i>';
                break;
        }
        return icon;
    },
    checkFn: function (arrFn) {
        arrFn = !Array.isArray(arrFn) ? [arrFn] : arrFn;
        arrFn.forEach(function (fn) {
            if (typeof fn !== 'function') {
                throw new Error('It should be a function');
            }
        });
        return true;
    },
    element: function (identity) {
        identity = identity ? identity : this.selector;
        var element = document.querySelector(identity);
        if (!element) {
            throw new Error('No any elements contains identity ['+identity+'].');
        }
        return element;
    },
    closest: function (elem, selector) {
        var firstChar = selector.charAt(0);
        // Get closest matching element
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
    },
    close: function () {
        this.setDisplayAttr(this.valueHideDisplay);
        this._config = null;
    },
    open: function () {
        this.setDisplayAttr(this.valueShowDisplay);
    },
    show: function (title, message, fn) {
        var callback = function () {};
        if (arguments.length === 0) {
            this.setConfig();
        } else if (arguments.length === 1 && typeof arguments[0] === 'function') {
            this.setConfig();
            callback = arguments[0];
        } else if (arguments.length === 1 && typeof arguments[0] === 'object') {
            this._config = arguments[0];
            this.setConfig();
        } else if (arguments.length === 2 && typeof arguments[0] === 'object' && typeof arguments[1] === 'function') {
            this._config = arguments[0];
            this.setConfig();
            callback = arguments[1];
        } else if (arguments.length === 2 && typeof arguments[0] === 'string' && arguments[1] === 'string') {
            this.setConfig();
            this.setHtml(this.classTitle, this.getIcon(this.typeMessage)+title);
            this.setHtml(this.classMessage, message);
        } else if (arguments.length === 3) {
            this.setConfig();
            this.setHtml(this.classTitle, this.getIcon(this.typeMessage)+arguments[0]);
            this.setHtml(this.classMessage, arguments[1]);
            callback = arguments[2];
        } else {
            throw new Error('Input arguments is invalid.');
        }
        this.events.no = callback;
        this.setButtons(false);
        this.open();
        return this;
    },
	confirm: function () {
        var title   = null,
            message = null,
            buttons = null,
            yes = null,
            no  = null;

        switch (arguments.length) {
            case 1:
                this.checkFn(arguments[0]);
                yes = arguments[0];
                break;
            case 2:
                this.checkFn([arguments[0], arguments[1]]);
                yes = arguments[0];
                no  = arguments[1];
                break;
            case 3:
                this.checkFn(arguments[2]);
                title   = arguments[0];
                message = arguments[1];
                yes     = arguments[2];
                break;
            case 4:
                title   = arguments[0];
                message = arguments[1];
                if (typeof arguments[2] === 'function') {
                    yes = arguments[2];
                    no  = arguments[3];
                } else if (typeof arguments[2] === 'object') {
                    buttons = arguments[2];
                    yes     = arguments[3];
                }
                break;
            case 5:
                this.checkFn([arguments[3], arguments[4]]);
                title   = arguments[0];
                message = arguments[1];
                buttons = arguments[2];
                yes     = arguments[3];
                no      = arguments[4];
                break;
            default:
                throw new Error('Only accepted [1-5] arguments.');
        }
        this.setHtml(this.classTitle, title);
        this.setHtml(this.classMessage, message);
        if (buttons) {
            this.setHtml(this.classSaveButton, buttons.ok);
            this.setHtml(this.classCancelButton, buttons.cancel);
        }

        this.events.yes = yes;
        this.events.no  = no;
        this.open();
        return this;
    },
    success: function () {
        this.typeMessage = 'success';
        return this.show(...arguments);
    },
    error: function () {
        this.typeMessage = 'error';
        return this.show(...arguments);
    },
    warning: function () {
        this.typeMessage = 'warning';
        return this.show(...arguments);
    },
    info: function () {
        this.typeMessage = 'info';
        return this.show(...arguments);
    },
    yes: function(element) {
        this.call('yes', element);
    },
    no: function(element) {
        this.call('no', element);
    },
    call: function (name, element) {
        if (typeof this.events[name] === 'function') {
            this.events[name].call(null, element);
        }
        this.next();
    },
    next: function () {
        if (!this.isWaiting) {
            this.close();
            this.setButtons();
        }
        this.isWaiting = false;
    }
};
