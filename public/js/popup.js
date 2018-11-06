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
    type: null,
    _msgLeave: null,
    _config: null,
    _icon: '',
    _withIcon: false,
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
        if (this._config && this.checkJson(this._config)) {
            var icon = this._icon || this.getIcon(this._config.type || this.type);
            this.setHtml(this.classTitle, icon+this._config.title);
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
        isMultiple = this.checkBool(isMultiple) ? isMultiple : true;
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
            default:
                icon = '';
        }
        return icon;
    },
    icon: function (icon) {
        this._withIcon = true;
        this._icon = icon || '';
        return this;
    },
    withIcon: function (icon) {
        return this.icon(icon);
    },
    message: function (msg) {
        this._msgLeave = msg;
        return this;
    },
    resetDefault: function () {
        this._icon = '';
        this._withIcon = false;
        this._config = null;
        this._msgLeave = null;
    },
    checkFn: function (arrFn) {
        return this.checkType(arrFn, 'function');
    },
    checkJson: function (arrJson) {
        return this.checkType(arrJson, 'object');
    },
    checkStr: function (arrStr) {
        return this.checkType(arrStr, 'string');
    },
    checkBool: function (arrBool) {
        return this.checkType(arrBool, 'boolean');
    },
    checkType: function (arrInput, type) {
        var flag = true;
        arrInput = !Array.isArray(arrInput) ? [arrInput] : arrInput;
        arrInput.forEach(function (input) {
            if (typeof input !== type) {
                flag = false;
                return false;
            }
        });
        return flag;
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
    },
    open: function () {
        this.setDisplayAttr(this.valueShowDisplay);
    },
    show: function (title, message, fn) {
        var callback = function () {};
        var numArgs = arguments.length;
        var icon = '';

        if (numArgs === 0) {
            this.setConfig();
        } else if (numArgs === 1 && this.checkFn(arguments[0])) {
            this.setConfig();
            callback = arguments[0];
        } else if (numArgs === 1 && this.checkJson(arguments[0])) {
            this._config = arguments[0];
            this.setConfig();
        } else if (numArgs === 2 && this.checkJson(arguments[0]) && this.checkFn(arguments[1])) {
            this._config = arguments[0];
            this.setConfig();
            callback = arguments[1];
        } else if (numArgs === 2 && this.checkStr([arguments[0], arguments[1]])) {
            this.setConfig();
            icon = this.getIcon(this.type);
            if (this._withIcon && this._icon) {
                icon = this._icon;
            }
            this.setHtml(this.classTitle, icon+arguments[0]);
            this.setHtml(this.classMessage, arguments[1]);
        } else if (numArgs === 3) {
            this.setConfig();
            icon = this.getIcon(this.type);
            if (this._withIcon && this._icon) {
                icon = this._icon;
            }
            this.setHtml(this.classTitle, icon+arguments[0]);
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
            yes = function () {},
            no  = function () {};

        this.type = 'confirm';
        // get icon if any
        if (this._withIcon) {
            this._icon = this._icon ? this._icon : this.getIcon(this.type);
        }

        // process input arguments
        switch (arguments.length) {
            case 1:
                if (this.checkJson(arguments[0])) {
                    this._config = arguments[0];
                } else if (this.checkFn(arguments[0])) {
                    yes = arguments[0];
                } else {
                    throw new Error('Argument should be a json or a function.');
                }
                break;
            case 2:
                if (this.checkJson(arguments[0]) && this.checkFn(arguments[1])) {
                    this._config = arguments[0];
                    yes = arguments[1];
                } else if (this.checkFn([arguments[0], arguments[1]])) {
                    yes = arguments[0];
                    no  = arguments[1];
                } else {
                    throw new Error('Arguments should be a json or a function.');
                }
                break;
            case 3:
                title   = arguments[0];
                message = arguments[1];
                if (this.checkFn(arguments[2])) {
                    yes = arguments[2];
                } else if (this.checkJson(arguments[2])) {
                    buttons = arguments[2];
                } else {
                    throw new Error('Third argument should be a json or a function.');
                }
                break;
            case 4:
                title   = arguments[0];
                message = arguments[1];
                if (this.checkFn([arguments[2], arguments[3]])) {
                    yes = arguments[2];
                    no  = arguments[3];
                } else if (this.checkJson(arguments[2]) && this.checkFn(arguments[3])) {
                    buttons = arguments[2];
                    yes     = arguments[3];
                } else {
                    throw new Error('Third argument or forth argument should be a json or a function.');
                }
                break;
            case 5:
                if (!this.checkFn(arguments[3]) || !this.checkFn(arguments[4])) {
                    throw new Error('Third, forth arguments should be a function.');
                }
                title   = arguments[0];
                message = arguments[1];
                buttons = arguments[2];
                yes     = arguments[3];
                no      = arguments[4];
                break;
            default:
                throw new Error('Only accept the maximum five arguments.');
        }

        // change title, meaasge and text of buttons if any
        if (title !== null || message !== null || buttons !== null){
            this.setHtml(this.classTitle, this._icon+title);
            this.setHtml(this.classMessage, message);
            if (buttons) {
                this.setHtml(this.classSaveButton, buttons.ok);
                this.setHtml(this.classCancelButton, buttons.no);
            }
        } else if (this._config) {
            this.setConfig();
        }

        this.events.yes = yes;
        this.events.no  = no;
        this.open();
        return this;
    },
    success: function () {
        this.type = 'success';
        return this.show(...arguments);
    },
    error: function () {
        this.type = 'error';
        return this.show(...arguments);
    },
    warning: function () {
        this.type = 'warning';
        return this.show(...arguments);
    },
    info: function () {
        this.type = 'info';
        return this.show(...arguments);
    },
    leave: function (message) {
        var msgDefaut = 'The previous changed date could be lost if leave or reload!';
        return message || this._msgLeave || msgDefaut;
    },
    yes: function(element) {
        this.call('yes', element);
    },
    no: function(element) {
        this.call('no', element);
    },
    call: function (name, element) {
        if (this.checkFn(this.events[name])) {
            this.events[name].call(null, element);
            this.resetDefault();
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
