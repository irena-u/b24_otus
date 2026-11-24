BX.addCustomEvent("onTimeManDataRecieved", function (params) {
        if (params["STATE"]!=="CLOSED") {
            return;
        }
        
        var arBtns = document.querySelectorAll('.timeman-instant-container button');
        arBtns.forEach(element => {
            if (element.innerText !== 'Начать рабочий день' && element.innerText !== 'Возобновить') {
                return;
            }

            if (element.dataset.confirmBound === '1') return; // не навешиваем повторно
            element.dataset.confirmBound = '1';
            
            element.addEventListener('click', function (e) {
                e.preventDefault();
                e.stopImmediatePropagation();

                var messageBox = new BX.UI.Dialogs.MessageBox({
                    message: "Вы действительно хотите начать?",
                    title: "Подтверждение действия",
                    buttons: BX.UI.Dialogs.MessageBoxButtons.OK_CANCEL,
                    okCaption: "Да",
                    cancelCaption: "Нет",
                    onOk: function (messageBox) {

                        console.log("onOk");
                        messageBox.close();
                        // действие при подтверждении
                        element.dataset.confirmBound = ''; // снимаем защиту
                        element.click();

                    },
                    onCancel: function (messageBox) {
                        console.log("onCancel");
                        messageBox.close();
                        // действие при отмене — ничего не делаем
                    },
                });
                
                messageBox.show();
                
            },{ capture: true, once: true });// once:true — обработчик удалится сам
        });
    });