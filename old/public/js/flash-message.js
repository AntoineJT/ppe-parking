(() => {
    function closeAlert(toClose) {
        toClose.parentNode.removeChild(toClose);
    }

    function listenToClickEvent(alertButton, alertBlock) {
        alertButton.addEventListener('click', () => closeAlert(alertBlock));
    }

    document.addEventListener('DOMContentLoaded', () => {
        const alertSuccessBlock = document.querySelector('div.alert-success');
        const alertErrorBlock = document.querySelector('div.alert-danger');
        const alertWarningBlock = document.querySelector('div.alert-warning');
        const alertInfoBlock = document.querySelector('div.alert-info');

        if (alertSuccessBlock !== null) {
            const alertSuccessButton = alertSuccessBlock.querySelector('button.close');
            listenToClickEvent(alertSuccessButton, alertSuccessBlock);
        }
        if (alertErrorBlock !== null) {
            const alertErrorButton = alertErrorBlock.querySelector('button.close');
            listenToClickEvent(alertErrorButton, alertErrorBlock);
        }
        if (alertWarningBlock !== null) {
            const alertWarningButton = alertWarningBlock.querySelector('button.close');
            listenToClickEvent(alertWarningButton, alertWarningBlock);
        }
        if (alertInfoBlock !== null) {
            const alertInfoButton = alertInfoBlock.querySelector('button.close');
            listenToClickEvent(alertInfoButton, alertInfoBlock);
        }
    });
})();
