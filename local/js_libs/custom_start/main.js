var skipConfirm = false;   
                
    BX.addCustomEvent("onTimeManDataRecieved", function (params) {
     console.log('onTimeManDataRecieved');
     console.log(params);
        if (params["STATE"]!=="CLOSED") {
            return;
        }
        
        var arBtns = document.querySelectorAll('.timeman-instant-container button');
        arBtns.forEach(element => {
            if (element.innerText !== 'Начать рабочий день' && element.innerText !== 'Возобновить') {
                return;
            }
            console.log('Нужная кнопка');
            // пропускаем один раз (после подтверждения)
            if (skipConfirm) {
                skipConfirm = false;
                return; // не мешаем штатному обработчику
            }
      
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
                        skipConfirm = true;
                        element.click();
                        
                    },
                    onCancel: function (messageBox) {
                        console.log("onCancel");
                        messageBox.close();
                        // действие при отмене — ничего не делаем
                    },
                });
                
                messageBox.show();
                
            }, true);
        });
    });

   
    /*var popup = BX.PopupWindowManager.create("popup-message", BX('element'), {
        content: "Hello World!" ,
        darkMode: true,
        autoHide: true 
    });
        popup.show();*/
// Dreamsite.all = function () {
//  BX.addCustomEvent("SidePanel.Slider:onLoad", function () {
// //  $.get("/local/tools/get_offices.php", function (data) {
// // $('.task-detail-comments').prepend(data);
// // });
// console.log('slider load event')
//  });
    // });