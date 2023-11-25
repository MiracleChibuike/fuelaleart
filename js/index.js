// ------------- This code is for displaying the password when the checkbox is checked

//------ Defining the Constant Variable for it
let UserInputPassword = document.getElementById("userPassword")
const PasswordShow = document.getElementById("passwordVisible");
let container = document.querySelector(".passwordText")
PasswordShow.addEventListener("click", function () {
    if (UserInputPassword.value == "") {
    alert("empty field")
}
else if (PasswordShow.checked) {
    UserInputPassword.type = "text"
    container.textContent = "Hide Password"
}else{
        UserInputPassword.type = "password"
         container.innerHTML = "Show Password"
         console.log(UserInputPassword.value)
    }
})

let manner 
let submitBtn = document.querySelector(".submitBtn")
submitBtn.addEventListener("click", function ValidateForm() {
    manner = document.getElementById("userEmail");
    let Mk = manner.value
    let AllJ = UserInputPassword.value;
    if (Mk == "") {
        alert("Please enter an email")
        event.preventDefault()
        // event.currentTarget.alert = "cannot submit empty form"
    }else if (AllJ == "") {
        alert(`Plaese enter a Password`)
           console.log(Mk);
            event.preventDefault();
    }
    else if (AllJ.length >= 30) {
        alert("Password cannot exceed 30 characters")
         event.preventDefault()
    }else if (AllJ.length <=5) {
        alert("Password Must Exceed 5 Characters")
        event.preventDefault();
    }else{
        alert("Success")
    }
})


    

// To display the Register Page on Click
// Defining the variables for each
// let loginPage = document.getElementById("main");
// let registerPage = document.querySelector(".FormBack");
// let btnShowRegisterPage = document.querySelector(".registerUser");
// btnShowRegisterPage.addEventListener("click", function (){
//     if (loginPage.style.contentVisibility = "visible") {
//         loginPage.style.contentVisibility = "hidden"
//         registerPage.style.contentVisibility = "visible"
//     }
// })



// if (PasswordShow.checked) {
    //     UserInputPassword.type = "text"
    //     container.textContent = "Hide Password"
    // }else if(UserInputPassword.value == ""){
    //     alert("error")
    // }
    // else{
    //     UserInputPassword.type = "password"
    //      container.innerHTML = "Show Password"
    // }
    // console.log(UserInputPassword.value)