//OJO DE LA CONTRASEÑA
const iconEye1 = document.querySelector(".eye1");

iconEye1.addEventListener("click", function (){
    const icon1 = this.querySelector("i");

    if (this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
        icon1.classList.remove("fa-eye-slash");
        icon1.classList.add("fa-eye");
    }else{
        this.nextElementSibling.type = "password";
        icon1.classList.remove("fa-eye");
        icon1.classList.add("fa-eye-slash");
    }
});

const iconEye2 = document.querySelector(".eye2");

iconEye2.addEventListener("click", function (){
    const icon2 = this.querySelector("i");

    if (this.nextElementSibling.type === "password"){
        this.nextElementSibling.type = "text";
        icon2.classList.remove("fa-eye-slash");
        icon2.classList.add("fa-eye");
    }else{
        this.nextElementSibling.type = "password";
        icon2.classList.remove("fa-eye");
        icon2.classList.add("fa-eye-slash");
    }
});