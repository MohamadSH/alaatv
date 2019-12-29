var CustomSelect = function () {

    var x, i, j, selElmnt, a, b, c, onChange = function (data) {};

    function getElement(elementId) {
        x = document.getElementById(elementId);
    }

    function createSelectedItem() {
        selElmnt = x.getElementsByTagName("select")[0];
        /* For each element, create a new DIV that will act as the selected item: */
        a = document.createElement("DIV");
        a.setAttribute("class", "select-selected");
        a.innerHTML = selElmnt.options[selElmnt.selectedIndex].innerHTML;
        x.appendChild(a);
    }

    function createOptions() {
        /* For each element, create a new DIV that will contain the option list: */
        b = document.createElement("DIV");
        b.setAttribute("class", "select-items select-hide");
        for (j = 0; j < selElmnt.length; j++) {
            /* For each option in the original select element,
            create a new DIV that will act as an option item: */
            c = document.createElement("DIV");
            c.innerHTML = selElmnt.options[j].innerHTML;
            c.setAttribute("data-option-value", selElmnt.options[j].getAttribute('value'));
            c.addEventListener("click", function(e) {
                /* When an item is clicked, update the original select box,
                and the selected item: */
                var y, i, k,
                    s = this.parentNode.parentNode.getElementsByTagName("select")[0],
                    sLength = s.length,
                    h = this.parentNode.previousSibling,
                    dov, index;

                for (i = 0; i < sLength; i++) {
                    if (s.options[i].innerHTML == this.innerHTML) {
                        s.selectedIndex = i;
                        h.innerHTML = this.innerHTML;
                        y = this.parentNode.getElementsByClassName("same-as-selected");
                        for (k = 0; k < y.length; k++) {
                            y[k].removeAttribute("class");
                        }
                        this.setAttribute("class", "same-as-selected");
                        dov = this.getAttribute('data-option-value');
                        index = i;
                        break;
                    }
                }
                h.click();
                h.setAttribute('data-option-value', h.getAttribute('data-option-value'));
                onChange({
                    index: index,
                    totalCount: sLength,
                    value: dov,
                    text: h.innerHTML
                });
            });
            b.appendChild(c);
        }
        x.appendChild(b);
        a.addEventListener("click", function(e) {
            /* When the select box is clicked, close any other select boxes,
            and open/close the current select box: */
            e.stopPropagation();
            closeAllSelect(this);
            this.nextSibling.classList.toggle("select-hide");
            this.classList.toggle("select-arrow-active");
        });
    }

    function closeAllSelect(elmnt) {
        /* A function that will close all select boxes in the document,
        except the current select box: */
        var x, y, i, arrNo = [];
        x = document.getElementsByClassName("select-items");
        y = document.getElementsByClassName("select-selected");
        for (i = 0; i < y.length; i++) {
            if (elmnt == y[i]) {
                arrNo.push(i)
            } else {
                y[i].classList.remove("select-arrow-active");
            }
        }
        for (i = 0; i < x.length; i++) {
            if (arrNo.indexOf(i)) {
                x[i].classList.add("select-hide");
            }
        }
    }

    return {
        init: function (data = {
            elementId: 'elementId',
            onChange: function (data) {}
        }) {
            getElement(data.elementId);
            onChange = data.onChange;
            createSelectedItem();
            createOptions();
            /* If the user clicks anywhere outside the select box, then close all select boxes: */
            document.addEventListener("click", closeAllSelect);
        }
    };
}();