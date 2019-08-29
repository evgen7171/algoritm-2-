'use strict';

class MathForm {

    constructor() {

        this.expressElem = document.getElementById('express');
        this.buttonElem = document.getElementById('button');
        this.treatElem = document.getElementById('treat');

        this.handleButton();
    }

    handleButton() {
        this.buttonElem.addEventListener('click', () => {
            this.express = this.expressElem.value;
            this.convolExpress();
        });
    }

    convolExpress() {
        // todo пробежаться по строке м заменить операции (свертка),
        //  которые в скобках на E0, E1, E2..

        // todo пробежаться по строке, опеределить операции
        // если от числа операция слева меньше в приоритете,
        // чем та, что справа - заключить в скобки ту, которая справа
        // если от числа операция слева больше или равна в приоритете,
        // чем та, что слева - заключить в скобки ту, которая слева

        //повторить сначала

        let str = this.express;
        let new_str = this.delimeter(str);
        console.log(new_str);
        this.treatElem.value = new_str;
    }

    priopity = oper => {
        switch (oper) {
            case '+':
            case '-':
                return 0;
            case '*':
            case '/':
                return 1;
            case '^':
                return 2;
        }
    };

    delimeter = str => {
        let numbers = [...str.matchAll(/\d+/g)];
        //todo надо чтобы строку преобразовывал к N01+N02-N03...
        // заменяя все числа строкой N... - всегда одной длины (например, =3)
        // которая получается из определения количества всех чисел

        //todo затем делает свертку того что в скобках...

        let brackets = [...str.matchAll(/[(,)]/g)];
        let operations = [...str.matchAll(/[+,\-,*,/,^]/g)];

        // let arr = [];
        // for (let i = 0; i < brackets.length - 1; i++) {
        //     if (brackets[i + 1]['index'] - brackets[i]['index'] === 4
        //         && brackets[i][0] === '(' && brackets[i + 1][0] === ')') {
        //         let elem = {
        //             'left': brackets[i]['index'],
        //             'right': brackets[i + 1]['index']
        //         };
        //         arr.push(elem);
        //     }
        // }
        // return arr;
        let arr = this.getArray(str);
        let maxIndexLetter = 0;
        let letters = [];
        let obj;
        let newArr = [];

        obj = this.changeElementsInArray(arr, maxIndexLetter);
        maxIndexLetter = obj['maxIndexLetter'];
        letters = letters.concat(obj['letters']);
        newArr = obj['newArr'];
        if (!this.compare(arr, newArr)) {
            obj = this.changeElementsInArray(arr, maxIndexLetter);
            maxIndexLetter = obj['maxIndexLetter'];
            letters = letters.concat(obj['letters']);
            newArr = obj['newArr'];
        }
        console.log(letters);
        if (!this.compare(arr, newArr)) {
            obj = this.changeElementsInArray(arr, maxIndexLetter);
            maxIndexLetter = obj['maxIndexLetter'];
            letters = letters.concat(obj['letters']);
            newArr = obj['newArr'];
        }
        console.log(letters);
        if (!this.compare(arr, newArr)) {
            obj = this.changeElementsInArray(arr, maxIndexLetter);
            maxIndexLetter = obj['maxIndexLetter'];
            letters = letters.concat(obj['letters']);
            newArr = obj['newArr'];
        }
        console.log(letters);

        this.letters = letters;
        this.newArr = newArr;
        return newArr.join('');
    };

    compare = (arr1, arr2) => JSON.stringify(arr1) === JSON.stringify(arr2);

    isNumber = char =>
        !isNaN(+char);

    isOperation = char =>
        char === '+' ||
        char === '-' ||
        char === '*' ||
        char === '/' ||
        char === '^';

    getArray(str) {
        const arr = [];
        let elem = '';
        for (let i = 0; i < str.length; i++) {
            if (this.isOperation(str[i]) || str[i] === '(' || str[i] === ')') {
                arr.push(str[i]);
            }
            if (this.isNumber(str[i])) {
                if (this.isNumber(arr[arr.length - 1])) {
                    arr[arr.length - 1] += str[i];
                } else
                    arr.push(str[i]);
            }
        }
        return arr;
    }

    changeElementsInArray = (arr, maxIndexLetter) => {
        let newArr = arr.slice();
        let brackets;
        if (newArr.length < 4) {
            return {
                maxIndexLetter: maxIndexLetter,
                letters: [],
                newArr: newArr
            }
        }
        const arrChanges = [];
        let num = maxIndexLetter;
        for (let i = 2; i < newArr.length - 2; i++) {
            if (newArr[i - 2] === '(' && newArr[i + 2] === ')') {
                let newElem = 'E' + num;
                num++;
                let elems = newArr.splice(i - 2, 5, newElem);
                arrChanges.push({
                    [newElem]: elems.join('')
                });
            }
        }
        return {
            maxIndexLetter: num,
            letters: arrChanges,
            newArr: newArr
        };
    };
}

const mathForm = new MathForm();