document.addEventListener('DOMContentLoaded', function () {

    // confirmacao nos botoes de excluir
    document.querySelectorAll('[data-confirm]').forEach(function (el) {
        el.addEventListener('click', function (e) {
            if (!confirm(el.getAttribute('data-confirm'))) {
                e.preventDefault();
            }
        });
    });

    // validacao do login
    var formLogin = document.getElementById('form-login');
    if (formLogin) {
        formLogin.addEventListener('submit', function (e) {
            limparErros(formLogin);
            var ok = true;
            var email = formLogin.querySelector('[name="email"]');
            var senha = formLogin.querySelector('[name="senha"]');

            if (!email.value.trim()) {
                mostrarErro(email, 'Informe o e-mail.');
                ok = false;
            } else if (!emailValido(email.value.trim())) {
                mostrarErro(email, 'E-mail inválido.');
                ok = false;
            }

            if (!senha.value.trim()) {
                mostrarErro(senha, 'Informe a senha.');
                ok = false;
            }

            if (!ok) e.preventDefault();
        });
    }

    // validacao do cadastro
    var formCadastro = document.getElementById('form-cadastro');
    if (formCadastro) {
        formCadastro.addEventListener('submit', function (e) {
            limparErros(formCadastro);
            var ok = true;
            var nome  = formCadastro.querySelector('[name="nome"]');
            var email = formCadastro.querySelector('[name="email"]');
            var senha = formCadastro.querySelector('[name="senha"]');

            if (!nome.value.trim()) {
                mostrarErro(nome, 'Informe seu nome.');
                ok = false;
            }

            if (!email.value.trim()) {
                mostrarErro(email, 'Informe o e-mail.');
                ok = false;
            } else if (!emailValido(email.value.trim())) {
                mostrarErro(email, 'E-mail inválido.');
                ok = false;
            }

            if (!senha.value.trim()) {
                mostrarErro(senha, 'Informe a senha.');
                ok = false;
            } else if (senha.value.length < 6) {
                mostrarErro(senha, 'A senha deve ter pelo menos 6 caracteres.');
                ok = false;
            }

            if (!ok) e.preventDefault();
        });
    }

    // validacao das ordens (nova e editar)
    var formOrdem = document.getElementById('form-ordem');
    if (formOrdem) {
        formOrdem.addEventListener('submit', function (e) {
            limparErros(formOrdem);
            var ok = true;
            var titulo = formOrdem.querySelector('[name="titulo"]');
            var descricao = formOrdem.querySelector('[name="descricao"]');

            if (titulo && !titulo.value.trim()) {
                mostrarErro(titulo, 'O título é obrigatório.');
                ok = false;
            }

            if (descricao && !descricao.value.trim()) {
                mostrarErro(descricao, 'A descrição é obrigatória.');
                ok = false;
            }

            if (!ok) e.preventDefault();
        });
    }

    // validacao do perfil
    var formPerfil = document.getElementById('form-perfil');
    if (formPerfil) {
        formPerfil.addEventListener('submit', function (e) {
            limparErros(formPerfil);
            var nome = formPerfil.querySelector('[name="nome"]');

            if (!nome.value.trim()) {
                mostrarErro(nome, 'O nome não pode ficar em branco.');
                e.preventDefault();
            }
        });
    }

    // validacao de usuario (novo e editar)
    var formUsuario = document.getElementById('form-usuario');
    if (formUsuario) {
        formUsuario.addEventListener('submit', function (e) {
            limparErros(formUsuario);
            var ok = true;
            var nome  = formUsuario.querySelector('[name="nome"]');
            var email = formUsuario.querySelector('[name="email"]');
            var senha = formUsuario.querySelector('[name="senha"]');

            if (nome && !nome.value.trim()) {
                mostrarErro(nome, 'Informe o nome.');
                ok = false;
            }

            if (email && !email.value.trim()) {
                mostrarErro(email, 'Informe o e-mail.');
                ok = false;
            } else if (email && !emailValido(email.value.trim())) {
                mostrarErro(email, 'E-mail inválido.');
                ok = false;
            }

            // campo senha so existe no formulario de novo usuario
            if (senha && !senha.value.trim()) {
                mostrarErro(senha, 'Informe a senha.');
                ok = false;
            } else if (senha && senha.value.length > 0 && senha.value.length < 6) {
                mostrarErro(senha, 'Mínimo 6 caracteres.');
                ok = false;
            }

            if (!ok) e.preventDefault();
        });
    }

    // busca ajax na pagina de ordens
    var inputBusca = document.getElementById('inputBusca');
    if (inputBusca) {
        var timer;

        inputBusca.addEventListener('keyup', function () {
            clearTimeout(timer);

            // pequeno delay pra nao disparar a cada letra
            timer = setTimeout(function () {
                var busca = inputBusca.value;
                var status = inputBusca.dataset.status || '';
                var prioridade = inputBusca.dataset.prioridade || '';

                var url = 'ajax_buscar_ordens.php?busca=' + encodeURIComponent(busca)
                    + '&status=' + encodeURIComponent(status)
                    + '&prioridade=' + encodeURIComponent(prioridade);

                fetch(url)
                    .then(function (res) { return res.json(); })
                    .then(function (ordens) {
                        var tbody = document.getElementById('corpoTabela');
                        tbody.innerHTML = '';

                        if (ordens.length == 0) {
                            tbody.innerHTML = '<tr><td colspan="8" class="text-center text-muted">Nenhuma ordem encontrada.</td></tr>';
                            return;
                        }

                        ordens.forEach(function (o) {
                            var badgePrio = '';
                            if (o.prioridade == 'alta')
                                badgePrio = '<span class="badge bg-danger">Alta</span>';
                            else if (o.prioridade == 'media')
                                badgePrio = '<span class="badge bg-warning text-dark">M\u00e9dia</span>';
                            else
                                badgePrio = '<span class="badge bg-secondary">Baixa</span>';

                            var badgeStatus = '';
                            if (o.status == 'aberta')
                                badgeStatus = '<span class="badge bg-danger">Aberta</span>';
                            else if (o.status == 'em andamento')
                                badgeStatus = '<span class="badge bg-warning text-dark">Em andamento</span>';
                            else
                                badgeStatus = '<span class="badge bg-success">Conclu\u00edda</span>';

                            var tecnico = o.tecnico_nome
                                ? o.tecnico_nome
                                : '<span class="text-muted">N\u00e3o atribu\u00eddo</span>';

                            tbody.innerHTML +=
                                '<tr>' +
                                '<td>' + o.id + '</td>' +
                                '<td><a href="ver_ordem.php?id=' + o.id + '">' + escHtml(o.titulo) + '</a></td>' +
                                '<td>' + escHtml(o.usuario_nome) + '</td>' +
                                '<td>' + tecnico + '</td>' +
                                '<td>' + badgePrio + '</td>' +
                                '<td>' + badgeStatus + '</td>' +
                                '<td>' + o.data_abertura + '</td>' +
                                '<td><a href="editar_ordem.php?id=' + o.id + '" class="btn btn-sm btn-warning">Editar</a></td>' +
                                '</tr>';
                        });
                    })
                    .catch(function (err) {
                        console.log('erro ao buscar ordens:', err);
                    });
            }, 400);
        });
    }

});

function mostrarErro(input, msg) {
    input.classList.add('is-invalid');
    var div = document.createElement('div');
    div.className = 'invalid-feedback';
    div.textContent = msg;
    input.parentNode.appendChild(div);
}

function limparErros(form) {
    form.querySelectorAll('.is-invalid').forEach(function (el) {
        el.classList.remove('is-invalid');
    });
    form.querySelectorAll('.invalid-feedback').forEach(function (el) {
        el.remove();
    });
}

function emailValido(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
}

// escapa html pra evitar xss ao montar a tabela
function escHtml(str) {
    var d = document.createElement('div');
    d.textContent = str;
    return d.innerHTML;
}
