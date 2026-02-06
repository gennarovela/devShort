# TerapiaBinaural® – Radar 7D PRO (Resumo do Produto)

Este documento descreve, em alto nível, os principais componentes e fluxos do plugin WordPress **TerapiaBinaural® – Radar 7D PRO**.

## Visão geral
- Plugin WordPress que cria um sistema interno (Admin + Terapeutas) para registrar atendimentos terapêuticos.
- Aplica o **Radar 7D** com pontuação **Atual/Desejado** e **7 perguntas por área**.
- Permite selecionar respostas que entram no relatório e gerar um **relatório textual copiável**.
- Controle de acesso por perfil:
  - **Admin** vê tudo.
  - **Terapeuta** vê apenas os próprios atendimentos.
- Paciente acessa **página com login e senha fora do WordPress** e visualiza apenas o relatório via **e‑mail + senha** definida pelo terapeuta.

## Administração
- Configuração de **perguntas** e **textos explicativos**.
- Gestão de **terapeutas**.
- **Gerenciador de estilo** com:
  - cores,
  - variáveis CSS,
  - ícones SVG inline,
  - logo e rodapé.

## Dados e armazenamento
- CPT: `tb_atendimento`
- `postmeta`:
  - `_tbr_data`
  - `_tbr_report_text`
  - `_tbr_patient_password`

## Interface e integrações
- UI baseada em **app.js/app.css**.
- Consome **endpoints AJAX do WordPress**.
