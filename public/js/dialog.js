const dialog = (function () {
    function Dialog() {
        this.selector = '.popup ';
        this.classMultipleFooter = '.modal-footer-multiple ';
        this.classSingleFooter = '.modal-footer-single ';
        this.classTitle = '.modal-title ';
        this.classMessage = '.modal-message ';
        this.classSaveButton = '.btnSaveModal ';
        this.classCancelButton = '.btnCancelModal ';
        this.classCloseButton = 'btnCloseModal ';
        this.valueShowDisplay = 'block ';
        this.valueHideDisplay = 'none ';
        this.isWaiting = false;
        this.events = {yes: null, no: null};
    }

    Dialog.prototype.id = function (id) {
        return this.setIdentity('#'+id);
    };

    Dialog.prototype.class = function (className) {
        return this.setIdentity('.'+className);
    };

    Dialog.prototype.identity = function (identity) {
        return this.setIdentity(identity);
    };

    Dialog.prototype.setIdentity = function (identity) {
        this.selector = identity;
        return this;
    };

    Dialog.prototype.wait = function () {
        this.isWaiting = true;
        return this;
    };

    Dialog.prototype.config = function (config) {

    };

    Dialog.prototype.setDisplayAttr = function (identity, value) {
        if (value === undefined) {
            this.element().style.display = identity;
        } else {
            this.element().querySelector(identity).style.display = value;
        }
    };

    Dialog.prototype.setButtons = function (isMultiple) {
        isMultiple = typeof isMultiple === 'boolean' ? isMultiple : true;
        this.setDisplayAttr(this.classMultipleFooter, isMultiple ? this.valueShowDisplay : this.valueHideDisplay);
        this.setDisplayAttr(this.classSingleFooter, isMultiple ? this.valueHideDisplay : this.valueShowDisplay);
    };

    Dialog.prototype.setHtml = function (identity, html) {
        if (identity && html !== undefined) {
            this.element().querySelector(identity).innerHTML = html;
        }
    };

    Dialog.prototype.checkFn = function (arrFn) {
        arrFn = !Array.isArray(arrFn) ? [arrFn] : arrFn;
        arrFn.forEach(function (fn) {
            if (typeof fn !== 'function') {
                throw new Error('It should be a function');
            }
        });
        return true;
    };

    Dialog.prototype.element = function (identity) {
        identity = identity ? identity : this.selector;
        var element = document.querySelector(identity);
        if (!element) {
            throw new Error('No any elements contains identity ['+identity+'].');
        }
        return element;
    };

    Dialog.prototype.closest = function (elem, selector) {
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
    };

    Dialog.prototype.close = function () {
        this.setDisplayAttr(this.valueHideDisplay);
    };

    Dialog.prototype.open = function () {
        this.setDisplayAttr(this.valueShowDisplay);
    };

	Dialog.prototype.confirm = function () {
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
            setHtml(this.classSaveButton, buttons.ok);
            setHtml(this.classCancelButton, buttons.cancel);
        }

        this.events.yes = yes;
        this.events.no  = no;
        this.open();
        return this;
    };

    Dialog.prototype.success = function (title, message, fn) {
        this.setHtml(this.classTitle, title);
        this.setHtml(this.classMessage, message);
        this.events.no = fn;
        this.setButtons(false);
        this.open();
        return this;
    };

    Dialog.prototype.error = function (title, message, fn) {
        this.setHtml(this.classTitle, title);
        this.setHtml(this.classMessage, message);
        this.events.no = fn;
        this.setButtons(false);
        this.open();
        return this;
    };

    Dialog.prototype.warning = function (title, message, fn) {
        this.setHtml(this.classTitle, title);
        this.setHtml(this.classMessage, message);
        this.events.no = fn;
        this.setButtons(false);
        this.open();
        return this;
    };

    Dialog.prototype.yes = function(element) {
        this.call('yes', element);
    };

    Dialog.prototype.no = function(element) {
        this.call('no', element);
    };

    Dialog.prototype.call = function (name, element) {
        if (typeof this.events[name] === 'function') {
            this.events[name].call(null, element);
        }
        this.next();
    };

    Dialog.prototype.next = function () {
        if (!this.isWaiting) {
            this.close();
            this.setButtons();
        }
        this.isWaiting = false;
    };

    // return {
    //     id: Dialog.prototype.id,
    //     wait: Dialog.prototype.wait,
    //     confirm: Dialog.prototype.confirm,
    //     success: Dialog.prototype.id,
    //     error: Dialog.prototype.id,
    //     warning: Dialog.prototype.id,
    // };
    return new Dialog;
})();
