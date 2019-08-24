var level0 = [];
var level1 = [];
var level2 = [];
var phpArray = '';
var counterForId = 0;

function getItemData(id) {
    let report;
    for (var key in lernitoTreeData) {
        if (lernitoTreeData[key]._id==id) {
            report = lernitoTreeData[key];
            break;
        }
    }
    return report;
}

function getItemChildren(itemm) {
    let childrensData = [];
    if(itemm.children.length>0) {

        for (var key in itemm.children) {
            let childData = getItemData(itemm.children[key]);
            if( typeof(childData) != 'undefined' && typeof(childData.children) != 'undefined' && childData.children.length>0) {
                childData.subChild = getItemChildren(childData);
            }
            childrensData.push(childData);
        }
        return childrensData;
    } else {
        return null;
    }
}

function printChildren(name, data) {

    let printText = '$'+name.split(' ').join('_')+' = [<br>';
    for (var key in data) {
        // printText += getChildNamesForPrint(data[key]);

        let dataaaForUnit = {
            'label': data[key].label,
            'child': getChildNamesForPrint(data[key])
        };
        printText += getUnitChildForPrint(dataaaForUnit);

        // let childData = getItemData(itemm.children[key]);
        // if( typeof(childData) != 'undefined' && typeof(childData.children) != 'undefined' && childData.children.length>0) {
        //     childData.subChild = getItemChildren(childData);
        // }
        // childrensData.push(childData);
    }
    printText += '];<br>';
    return printText;
}

function getUnitChildForPrint(data) {
    if(data.child == '[]') {
        data.child = '';
    }
    let counter = counterForId++;
    let printText = "[<br>'id' => '"+(counter)+"',<br>";
    printText += "'text' => '"+data.label+"',<br>";
    printText += "'tags' => json_encode(['"+data.label.split(' ').join('_')+"'], JSON_UNESCAPED_UNICODE),<br>";
    printText += "'children' => [<br>"+data.child+"<br>]<br>],<br>";
    return printText;
}

function getChildNamesForPrint(data) {
    let printText = "";
    for (var key in data.subChild) {
        if( typeof(data.subChild[key].subChild) != 'undefined' && data.subChild[key].subChild.length>0) {

            let chillll = getChildNamesForPrint(data.subChild[key]);
            let dataaa = {
                'label': data.subChild[key].label,
                'child': chillll
            };
            printText += getUnitChildForPrint(dataaa);

            // for (var key2 in data.subChild[key].subChild) {
            //     let chillll = getChildNamesForPrint(data.subChild[key].subChild[key2]);
            //     let dataaa = {
            //         'label': data.subChild[key].label,
            //         'child': chillll
            //     };
            //     printText += getUnitChildForPrint(dataaa);
            // }
        } else {
            let dataaa = {
                'label': data.subChild[key].label,
                'child': '[]'
            };
            printText += getUnitChildForPrint(dataaa);
        }
    }
    if(printText == "") {
        // printText = "[]";
    }
    return printText;
}

function updateSelectedItems() {
    let selectedIds = $('#html').jstree("get_selected");
    let selectedItemsText = [];
    for (var key in selectedIds) {
        if( typeof(treePathData) != 'undefined' && typeof(treePathData[selectedIds[key]]) != 'undefined' ) {
            selectedItemsText.push(treePathData[selectedIds[key]].ps);
        }
    }
    // console.log('selectedItemsText: ', selectedItemsText);

    let sameReport = matchString(selectedItemsText);

    selectedItemsText = sameReport.array;

    // create explanation text
    let counter = 1;
    let html = '';
    for (var key in selectedItemsText) {
        html += '<li>' + (counter++) + ') ' + selectedItemsText[key] + '</li>';
    }
    let reportTextForPrint = '';
    if(sameReport.sameText.length>0) {
        reportTextForPrint = '<ul><li>' + sameReport.sameText + '<ul>' + html +'</ul></li></ul>';
    } else {
        reportTextForPrint = '<ul>' + html + '</ul>';
    }
    $('#event_result').html(reportTextForPrint);
    $('#valueOfExplanation').val($('#event_result').html());

    // create tags report text in json format
    // let tagsAraray = [];
    // let sameReportPrArray = sameReport.prArray.length;
    // for (var key in sameReport.prArray) {
    //     let itemLength = sameReport.prArray[key].length;
    //     tagsAraray.push(sameReport.prArray[key][itemLength-1]);
    // }
    // $('#valueOfTags').html(JSON.stringify(tagsAraray));

    // console.log(sameReport.prArray);
    $('#valueOfTags').html(JSON.stringify(sameReport.prArray));
    
}

function PrintPreview() {
    var Contractor= $('#event_result').html();
    printWindow = window.open("", "", "location=1,status=1,scrollbars=1,width=650,height=600");
    printWindow.document.write('<html><head>');
    printWindow.document.write('<style type="text/css">*, body { direction: rtl; text-align: right; } @media print{.no-print, .no-print *{display: none !important;}</style>');
    printWindow.document.write('</head><body>');
    printWindow.document.write('<div style="width:100%;text-align:right">');


    //Print and cancel button
    printWindow.document.write('<input type="button" id="btnPrint" value="چاپ" class="no-print" style="width:100px" onclick="window.print()" />');
    printWindow.document.write('<input type="button" id="btnCancel" value="بستن صفحه" class="no-print"  style="width:100px" onclick="window.close()" />');


    printWindow.document.write('</div>');

    //You can include any data this way.
    printWindow.document.write(Contractor);

    // printWindow.document.write(document.getElementById('forPrintPreview').innerHTML);

    printWindow.document.write('</body></html>');
    printWindow.document.close();
    printWindow.focus();
}

function matchString(strArray) {
    // create prArray
    let strArrayLength = strArray.length;
    let maxLength = 0;
    let prArray = [];
    for (var i = 0; i < strArrayLength; i++) {
        let strItemArray = strArray[i].split('@@**@@');
        prArray.push(strItemArray);
        let strItemArrayLength = strItemArray.length;
        if(maxLength<strItemArrayLength) {
            maxLength = strItemArrayLength;
        }
    }


    // check same items
    let sameIndex = 0;
    let prArrayLength = prArray.length;
    let allItemIsSame = true;
    for (var i = 0; i < maxLength; i++) {
        let checkText = '';
        for (var j = 0; j < prArrayLength; j++) {
            if( typeof(prArray[j][i]) != 'undefined' ) {
                if(j==0) {
                    checkText = prArray[j][i];
                }
                if(prArray[j][i]!=checkText) {
                    allItemIsSame = false;
                }
                if(!allItemIsSame) {
                    sameIndex = i;
                    break;
                }
            } else {
                break;
            }
        }
        if(!allItemIsSame) {
            break;
        }
    }

    // create report
    let returnArray = [];
    for (var i = 0; i < prArrayLength; i++) {
        let itemLength = prArray[i].length;
        let itemText = '';
        for (var j = sameIndex; j < itemLength; j++) {
            itemText += prArray[i][j]+', ';
        }
        itemText = cleanLastSign(itemText);
        returnArray.push(itemText);
    }
    let firstItemLength = (prArray.length>0)?prArray[0].length:0;
    let sameText = '';
    for (var j = 0; j < sameIndex; j++) {
        sameText += prArray[0][j]+', ';
    }
    sameText = cleanLastSign(sameText);

    return {
        'array': returnArray,
        'sameText': sameText,
        'prArray': prArray
    };

}

function cleanLastSign(str) {
    return str.substring(0, str.length-2);
}
//
// function showAlert(message) {
//     $('#report').html(message);
//     $('#report').fadeIn('fast');
//     setTimeout(hideAlert(),2000);
// }
// function hideAlert() {
//     $('#report').fadeIn('slow');
// }

$( document ).ready(function() {
    $(document).on('click', '.btnPrintResult', function (e, data) {
        PrintPreview();
    });
    $(document).on('click', '.btnCopyExplanation', function (e, data) {

        $('#valueOfExplanation').val($('#event_result').html());
        var copyTextarea = document.querySelector('#valueOfExplanation');
        copyTextarea.focus();
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            // console.log('Copying text command was :' + msg);
            alert('توضیحات کپی شدند!');
        } catch (err) {
            // console.log('Oops, unable to copy');
        }

    });
    $(document).on('click', '.btnCopyTags', function (e, data) {

        var copyTextarea = document.querySelector('#valueOfTags');
        copyTextarea.focus();
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            // console.log('Copying text command was :' + msg);
            alert('تگها کپی شدند!');
        } catch (err) {
            // console.log('Oops, unable to copy');
        }

    });
    $(document).on('click', '.btnCopyConvertedAlaaNodeArrayToStringFormat', function (e, data) {

        var copyTextarea = document.querySelector('#selectedConvertedAlaaNodeArrayToStringFormat');
        copyTextarea.focus();
        copyTextarea.select();

        try {
            var successful = document.execCommand('copy');
            var msg = successful ? 'successful' : 'unsuccessful';
            // console.log('Copying text command was :' + msg);
            alert('متن آرایه کپی شد!');
        } catch (err) {
            // console.log('Oops, unable to copy');
        }

    });
});






