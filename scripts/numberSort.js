let array = [5,	25,	13,	8,	45,	6,	11, 12, 0, 50, 1, 10, 55, 4, 45];
// document.getElementById("arrayData").innerHTML = array;
renderNums('arrayData', array)

// sort the array from the begining

for (i=0; i<array.length; i++){
    for (j=i; j<array.length; j++){
        if (array[i] > array[j]){
            tmp = array[i];
            array[i] = array[j];
            array[j] = tmp;
        }
    }
}
console.log('Script executed successfully, array sorted !')

function getMax(){
    // return array[array.length-1];
    document.getElementById("resultDisplayBox").innerHTML = array[array.length-1];
}

function getMin(){
    // return array[0];
    document.getElementById("resultDisplayBox").innerHTML = array[0];
}

function getArrMinMax(){
    // return array;
    document.getElementById("resultDisplayBox").innerHTML = null;
    renderNums('resultDisplayBox', array);
}

function getArrMaxMin(){
    arrcpy = [...array]
    // return arrcpy.reverse();
    document.getElementById("resultDisplayBox").innerHTML = null;
    renderNums('resultDisplayBox', arrcpy.reverse());
}

// console.log(getArrMaxMin());
// console.log(getArrMinMax());

function renderNums(targetID, data){
    data.map((n)=>{
        const newNum = document.createElement("span");
        newNum.innerHTML=n;
        newNum.setAttribute('class', "arrNumber");
        numDisplay = document.getElementById(targetID);
        numDisplay.appendChild(newNum);
    });
}