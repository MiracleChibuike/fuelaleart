// ------------- This code is for displaying the password when the checkbox is checked

//------ Defining the Constant Variable for it
let userNameId = document.getElementById("userName")
let UserInputPassword = document.getElementById("userPassword")
let userInputMail = document.getElementById("userEmail");
const PasswordShow = document.getElementById("passwordVisible");
let container = document.querySelector(".passwordText");
PasswordShow.addEventListener("click", function () {
    let caseKK = userInputMail.value;
      if (UserInputPassword.value == "") {
    alert("empty field")
}
else if (PasswordShow.checked) {
    UserInputPassword.type = "text"
    container.textContent = "Hide Password"
}else{
        UserInputPassword.type = "password"
         container.innerHTML = "Show Password"
         console.log(UserInputPassword.value);
                // console.log(caseKK);
                return caseKK

    }
    //    console.log(userInputMail.value)
    //    let mailReceive = userInputMail.value;
    //    alert(mailReceive)
       
})

// ----------- For the Submit Button Onclick to manipulate the Form -----
// Form validation
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


