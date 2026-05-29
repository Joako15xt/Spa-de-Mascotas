document.addEventListener('DOMContentLoaded', function(){
    const pass = document.getElementById('password');
    const bar = document.getElementById('passBar');

    if(pass && bar){
        pass.addEventListener('input', function(){
            let v = pass.value;
            let score = 0;

            if(v.length >= 8) score++;
            if(/[A-Z]/.test(v)) score++;
            if(/[a-z]/.test(v)) score++;
            if(/[0-9]/.test(v)) score++;
            if(/[\W_]/.test(v)) score++;

            let width = (score * 20);
            bar.style.width = width + "%";

            if(score <= 2){
                bar.className = "progress-bar bg-danger";
                bar.textContent = "Débil";
            } else if(score <= 4){
                bar.className = "progress-bar bg-warning";
                bar.textContent = "Media";
            } else {
                bar.className = "progress-bar bg-success";
                bar.textContent = "Fuerte";
            }
        });
    }
});
function togglePassword(id){
    const input = document.getElementById(id);
    if(!input) return;

    input.type = input.type === "password" ? "text" : "password";
}