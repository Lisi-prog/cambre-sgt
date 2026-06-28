let enviando = false;

document.getElementById('btn-guardar').addEventListener('click', function () {

    if (enviando) return;

    let tabActiva = document.querySelector('.tab-pane.active');
    let form = null;

    if (tabActiva.id === 'serv-ing') {
        form = document.getElementById('form-serv-ing');
    }

    if (tabActiva.id === 'serv-mant') {
        form = document.getElementById('form-serv-mant');
    }

    if (!form) return;

    // if (form.id === 'form-serv-mant') {
    //     const checkeados = form.querySelectorAll('input[name="sintomas[]"]:checked');

    //     if (checkeados.length === 0) {
    //         alert('Debe seleccionar al menos un síntoma.');
    //         return;
    //     }
    // }

    enviando = true;

    this.disabled = true;
    this.innerHTML = 'Guardando...';

    form.requestSubmit(); // ✅ clave
});

document.querySelectorAll('form').forEach(form => {
    form.addEventListener('invalid', () => {
        enviando = false;
        const btn = document.getElementById('btn-guardar');
        btn.disabled = false;
        btn.innerHTML = 'Guardar';
    }, true);
});

function toggleCheck(id) {
    const check = document.getElementById(`chkTareaPrend${id}`);

    if (!check) {
        return;
    }

    check.checked = !check.checked;
}