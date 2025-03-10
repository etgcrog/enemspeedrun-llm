Este é um acordo legal entre você (doravante denominado "Usuário") e os autores Eduardo Teles (doravante denominado "Autor"). Leia este acordo com atenção antes de usar o software. Ao usar o software, você concorda em ficar vinculado aos termos deste acordo.

1. Licença de Uso:
   Os Autores concedem ao Usuário uma licença não exclusiva e intransferível para usar o software fornecido pelos Autores (doravante denominado "Software"). O Software é fornecido apenas para uso pessoal e não comercial.

2. Restrições:
   O Usuário concorda que não irá:
   a. modificar, adaptar ou criar obras derivadas do Software;
   b. distribuir, sublicenciar, alugar ou emprestar o Software;
   c. descompilar, realizar engenharia reversa ou tentar descobrir o código-fonte do Software;
   d. remover ou alterar qualquer aviso de direitos autorais, marca registrada ou outras notificações de propriedade do Software.

3. Propriedade:
   O Software é propriedade exclusiva dos Autores e está protegido pelas leis de direitos autorais e outras leis de propriedade intelectual. Os Autores reservam todos os direitos não expressamente concedidos ao Usuário neste acordo.

4. Comercialização:
   É expressamente proibida a comercialização do Software, exceto pelos Autores. Qualquer venda, distribuição ou lucro obtido com o Software sem o consentimento dos Autores constituirá violação deste acordo.

5. Suporte:
   Os Autores não são obrigados a fornecer suporte técnico, manutenção ou atualizações para o Software, embora possam optar por fazê-lo a seu critério.

6. Rescisão:
   Este acordo é eficaz até ser rescindido. O Usuário pode rescindir este acordo a qualquer momento excluindo e destruindo todas as cópias do Software em sua posse. Este acordo será rescindido automaticamente se o Usuário violar qualquer uma das disposições deste acordo. Após a rescisão, o Usuário deve cessar imediatamente todo o uso do Software e destruir todas as cópias em sua posse.

7. Isenção de Garantia:
   O Software é fornecido "no estado em que se encontra", sem garantia de qualquer tipo, expressa ou implícita, incluindo, mas não se limitando a, garantias de comercialização, adequação a uma finalidade específica e não violação.

8. Limitação de Responsabilidade:
   Em nenhuma circunstância os Autores serão responsáveis por quaisquer danos diretos, indiretos, incidentais, especiais, consequenciais ou exemplares decorrentes do uso ou incapacidade de uso do Software, mesmo que os Autores tenham sido avisados da possibilidade de tais danos. Alguns estados não permitem a exclusão ou limitação de responsabilidade por danos consequenciais ou incidentais, portanto, a limitação acima pode não se aplicar ao Usuário.

9. Lei Aplicável:
   Este acordo será regido e interpretado de acordo com as leis do Brasil. Qualquer ação decorrente ou relacionada a este acordo será apresentada exclusivamente nos tribunais competentes localizados no Brasil.

10. Aceitação:
    Ao usar o Software, o Usuário reconhece que leu este acordo, compreendeu e concordou em ficar vinculado aos seus termos e condições. Se o Usuário não concordar com os termos deste acordo, não deverá usar o Software.

Contato:
Se o Usuário tiver alguma dúvida sobre este acordo, pode entrar em contato com os Autores em:

Eduardo Teles: +5561982611454

Este documento constitui o acordo completo entre o Usuário e os Autores em relação ao assunto aqui tratado e substitui todos os acordos anteriores ou contemporâneos, entendimentos ou comunicações, sejam escritos ou verbais, relacionados a tal assunto.


# Tricks 

Remove-Item -Recurse -Force vendor, composer.lock
composer clear-cache

composer install --no-cache
composer dump-autoload -o

composer require --prefer-dist --no-interaction yiisoft/yii2-gii

php yii migrate/down 1

php yii migrate --interactive=0
php yii serve --port=8000


DROP SCHEMA public CASCADE;
CREATE SCHEMA public;

REFEREN:

https://medium.com/@danushidk507/using-pymupdf4llm-a-practical-guide-for-pdf-extraction-in-llm-rag-environments-63649915abbf
