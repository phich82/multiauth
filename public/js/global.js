var app = app || {};

app.popup = {
    timereport: {
        confirm: {
            title: 'Confirm',
            message: 'This is a confirmation.',
            buttons: {
                ok: 'OK',
                no: 'Cancel'
            },
            //type: 'confirm'
        },
        success: {
            title: 'Saved',
            message: 'A row has been saved successfully.',
            buttons: {
                close: 'Close'
            },
            //type: 'success'
        },
        error: {
            title: 'Saved',
            message: 'Saved failed.',
            buttons: {
                close: 'Close'
            },
            //type: 'error'
        },
        warning: {
            title: 'Saved',
            message: 'Missing data.',
            buttons: {
                close: 'Close'
            },
            //type: 'warning'
        },
        info: {
            title: 'Notification',
            message: 'Missing data.',
            buttons: {
                close: 'Close'
            },
            //type: 'info'
        }
    }
}
