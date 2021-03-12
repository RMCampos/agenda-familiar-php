"use strict";

var main = function() {
    limpar();
            
    $('.list-group li').click(function(e) {
        e.preventDefault();
        
        // Se selecionada, limpa tudo
        if ($(this).hasClass('active')) {
            limpar($(this));
            return;
        }
        
        // Desmarca qualquer outra linha selecionada
        $(this).parent().find('li').removeClass('active');
        
        // Seleciona a linha atual
        $(this).addClass('active');
        
        // Se página calendarios, busca o calendarioAtual e atualiza na tela
        if ($('#nome').length) {
            $.getJSON('/Calendarios/getId/' + $(this).find('span[class=hidden]').text(), function(responseOK) {
                atualizarCampos(responseOK);
            });
        }
        
        // Se página aniversarios, busca o aniversarioAtual e atualiza na tela
        if ($('#descricao').length) {
            $.getJSON('/Aniversarios/getId/' + $(this).find('span[class=hidden]').text(), function(responseOK) {
                atualizarCampos(responseOK);
            });
        }
        
        // Esconde o botão cadastrar
        $('#btnCadastrar').addClass('hidden');
        
        // Mostra os botões de alterar, excluir e cancelar
        $('.btnAction').removeClass('hidden');
        
    });
    $('#btnAlterar').click(function() {
        var f = document.getElementById('form');
        var m = document.getElementById('methodInput');
        if (f && m) {
            m.setAttribute('name', "");
            m.setAttribute('value', "");
            f.submit();
        }
    });
    $('#btnExcluir').click(function() {
        $('#divExcluir').removeClass('hidden');
    });
    $('#btnCancelar').click(function() {
        limpar();
    });
    $('#naoCancelar').click(function() {
        limpar();
    });
    $('#simExcluir').click(function() {
        var f = document.getElementById('form');
        var m = document.getElementById('methodInput');
        if (f && m) {
            m.setAttribute('name', "_METHOD");
            m.setAttribute('value', "DELETE");
            f.submit();
        }
    });
};

function atualizarCampos(data) {
    if ($('#id').length && data.id) $('#id').val(data.id);
    if ($('#nome').length && data.nome) $('#nome').val(data.nome);
    if ($('#dia').length && data.dia) $('#dia').val(data.dia);
    if ($('#mes').length && data.mes) $('#mes').val(data.mes);
    if ($('#ano').length && data.ano) $('#ano').val(data.ano);
    if ($('#descricao').length && data.descricao) $('#descricao').val(data.descricao);
    if ($('#id_calendarios').length && data.id_calendarios) $('#id_calendarios').val(data.id_calendarios);
}

function limpar(aElement) {
    if (aElement) aElement.toggleClass('active');
    else {
        $('.list-group a').each(function() {
            $(this).removeClass('active');
        });
    }
    if ($('#id').length) $('#id').val("");
    if ($('#nome').length) $('#nome').val("");
    if ($('#dia').length) $('#dia').val("");
    if ($('#mes').length) $('#mes').val("");
    if ($('#ano').length) $('#ano').val("");
    if ($('#descricao').length) $('#descricao').val("");
    if ($('#id_calendarios').length) $('#id_calendarios').val("");
    if ($('#btnCadastrar').length) $('#btnCadastrar').removeClass('hidden');
    if ($('.btnAction').length) $('.btnAction').addClass('hidden');
    if ($('#divExcluir').length) $('#divExcluir').addClass('hidden');
}

$(document).ready(main);