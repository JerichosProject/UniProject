let result=AddTwoNumbers(2,3);

console.warn('2+3='+result);

SayHello();

function SayHello() {
    document.write("Hello<br/>");
}

function AddTwoNumbers(num1,num2) {
    return num1+num2;
}

var someObject={};
someObject.name="Jericho";
someObject.age=23;
someObject.WhoAmI=function() {
    document.write('I am '+someObject.name+', and  I am '+someObject.age+'<br/>');
};
someObject.compiled=function() {
    return someObject.name+' '+someObject.age;
};
someObject["ss-"]="random";

someObject.WhoAmI();

console.log(someObject.compiled());
console.log(someObject["ss-"]);

// these are the same [
    var add=function(a,b) {
        return a+b;
    }

    console.log('var add=function(a,b) { return a+b; } ==== Result is '+add(2,4));

    //the below is a lot less;
    add=(a,b)=>a+b;
    console.log('add=(a,b)=>a+b ===== Result is '+add(6,3));
// ]

// just for faster ways of writing code [
    add=(a,b)=>a+b;
    console.log("result : "+add(6,3));
    add=(a,b)=>{return a+b;};
    console.log("add=(a,b) result : "+add(2,3));
    add=a=>a+2;
    console.log("dd=a=> result : "+add(6,3));
    add=()=>{return 2+4};
    console.log("add=()=> result : "+add());
// ]

// lambda annon functions [
    function Add(n1,n2,output) {
        let result=n1+n2;
        output(result);
    }
    Add(2,3,(x)=>{console.log("Add(2,3,(x)=>{}); Result is "+x);});
//]

// function DoSomething() {
//     return new Promise(function(resolve,reject) {
//         if(some_error) reject(new Error("Oh no!"));
//         else resolve(result);
//     });
// }

function someAsyncFunction() {
    return new Promise(function(resolve,reject) {
        setTimeout(function(){
            var num=Math.floor(Math.random() * 11);
            if(num%2) resolve(num);
            else reject('number is even');
        },300);
    });
}

function onResolveCallback(result) {
    console.warn("Result : "+result);
}

function onRejectCallback(error) {
    console.error("Result : "+error);
}

var promise = someAsyncFunction();
promise.then(onResolveCallback,onRejectCallback)

async function ReadNumber() {
    try{
        var num=await someAsyncFunction();
        console.log("ReadNumber success | Read number is "+num);
    } catch(error) {
        console.error('ReadNumber error | '+error);
    }
}
ReadNumber();