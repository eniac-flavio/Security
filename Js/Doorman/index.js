/* https://www.w3schools.com/howto/howto_js_tabs.asp */
function openEnterExit(evt, cityName) {
    var i, tabbercontent, tabbernavlink, inputareas

    tabbercontent = document.getElementsByClassName("tabber-content")
    for (i = 0; i < tabbercontent.length; i++) {
        tabbercontent[i].style.display = "none"
    }

    tabbernavlink = document.getElementsByClassName("tabber-nav-link")
    for (i = 0; i < tabbernavlink.length; i++) {
        tabbernavlink[i].className = tabbernavlink[i].className.replace(" active", "")
    }

    inputareas = document.getElementsByClassName("input-area")
    for (i = 0; i < inputareas.length; i++) {
        if (inputareas[i].classList.contains("input-" + cityName)) {
            inputareas[i].style.display = "block"
        } else {
            inputareas[i].style.display = "none"
        }
    }

    document.getElementById(cityName).style.display = "block"
    evt.currentTarget.className += " active"
}

document.getElementById("defaultOpen").click();
/* https://www.w3schools.com/howto/howto_js_tabs.asp */

function toggleInput(entradaOuSaida, tipo) {
    var placa = document.getElementById(entradaOuSaida + 'placa');
    var cpf = document.getElementById(entradaOuSaida + 'cpf');
    var labelVeiculo = document.querySelector('label[for="' + entradaOuSaida + 'veiculo"]');
    var labelPessoa = document.querySelector('label[for="' + entradaOuSaida + 'pessoa"]');

    if (tipo === 'veiculo') {
        placa.classList.remove('displaynone');
        cpf.classList.add('displaynone');
        labelVeiculo.classList.add('checked');
        labelPessoa.classList.remove('checked');
    } else if (tipo === 'pessoa') {
        cpf.classList.remove('displaynone');
        placa.classList.add('displaynone');
        labelPessoa.classList.add('checked');
        labelVeiculo.classList.remove('checked');
    }
}

document.getElementById('eveiculo').addEventListener('change', function () {
    toggleInput('e', 'veiculo');
});

document.getElementById('epessoa').addEventListener('change', function () {
    toggleInput('e', 'pessoa');
});

document.getElementById('sveiculo').addEventListener('change', function () {
    toggleInput('s', 'veiculo');
});

document.getElementById('spessoa').addEventListener('change', function () {
    toggleInput('s', 'pessoa');
});

toggleInput('e', 'veiculo');
toggleInput('s', 'veiculo');

function formatCPF(cpf) {
    cpf = cpf.replace(/\D/g, '');
    cpf = cpf.slice(0, 11);
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d)/, '$1.$2');
    cpf = cpf.replace(/(\d{3})(\d{1,2})$/, '$1-$2');
    return cpf;
}

function updateCPFField(input) {
    input.value = formatCPF(input.value);
}

const cpfInputEntrada = document.getElementById('ecpf');
const cpfInputSaida = document.getElementById('scpf');

cpfInputEntrada.addEventListener('input', function () {
    updateCPFField(this);
});

cpfInputSaida.addEventListener('input', function () {
    updateCPFField(this);
});

function formatPlate(plate) {
    plate = plate.replace(/[^A-Z0-9]/gi, '').toUpperCase().slice(0, 7);

    var chars = plate.split('');
    for (var i = 0; i < chars.length; i++) {
        if (i < 3 && !/[A-Z]/.test(chars[i])) {
            chars[i] = '';
        } else if (i === 3 && !/[0-9]/.test(chars[i])) {
            chars[i] = '';
        } else if (i > 4 && !/[0-9]/.test(chars[i])) {
            chars[i] = '';
        }
    }

    plate = chars.join('');

    return plate;
}

function updatePlateField(input) {
    input.value = formatPlate(input.value);
}

const plateInputEntrada = document.getElementById('eplaca');
const plateInputSaida = document.getElementById('splaca');

plateInputEntrada.addEventListener('input', function () {
    updatePlateField(this);
});

plateInputSaida.addEventListener('input', function () {
    updatePlateField(this);
});

function isComplete(input) {
    if (input.id.endsWith('placa')) {
        return input.value.length === 7;
    } else if (input.id.endsWith('cpf')) {
        return input.value.length === 14;
    }
    return false;
}

function updateSubmitButton(entradaOuSaida) {
    var veiculoRadio = document.getElementById(entradaOuSaida + 'veiculo');
    var pessoaRadio = document.getElementById(entradaOuSaida + 'pessoa');
    var placaInput = document.getElementById(entradaOuSaida + 'placa');
    var cpfInput = document.getElementById(entradaOuSaida + 'cpf');
    var submitButton = document.getElementById(entradaOuSaida + 'submit');

    if ((veiculoRadio.checked && isComplete(placaInput)) || (pessoaRadio.checked && isComplete(cpfInput))) {
        submitButton.classList.remove('safety');
    } else {
        submitButton.classList.add('safety');
    }
}

function clearUnusedInput(entradaOuSaida) {
    var veiculoRadio = document.getElementById(entradaOuSaida + 'veiculo');
    var pessoaRadio = document.getElementById(entradaOuSaida + 'pessoa');
    var placaInput = document.getElementById(entradaOuSaida + 'placa');
    var cpfInput = document.getElementById(entradaOuSaida + 'cpf');

    if (veiculoRadio.checked) {
        cpfInput.value = '';
    } else if (pessoaRadio.checked) {
        placaInput.value = '';
    }
}

['e', 's'].forEach(function (entradaOuSaida) {
    ['veiculo', 'pessoa'].forEach(function (tipo) {
        document.getElementById(entradaOuSaida + tipo).addEventListener('change', function () {
            updateSubmitButton(entradaOuSaida);
            clearUnusedInput(entradaOuSaida);
        });
    });

    ['placa', 'cpf'].forEach(function (campo) {
        document.getElementById(entradaOuSaida + campo).addEventListener('input', function () {
            updateSubmitButton(entradaOuSaida);
        });
    });
});