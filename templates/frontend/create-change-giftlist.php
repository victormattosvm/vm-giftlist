<?php 
    if($giftlist){
        $meta = get_post_meta($giftlist->id, '', true);
    }
?>
    <form  class="form-lista" class="row justify-content-start" method="post">
    <?php wp_nonce_field('process-giftlist') ?>
        <input type="hidden" value="<?= $giftlist? $giftlist->id : '' ?>" name="giftlist-id">
        <div class="col-6" >
            <label for="data-evento"> Data do evento:</label>
            <input type="date" name="data-evento" class="input-text" value="<?= $meta['_data_evento'][0]? $meta['_data_evento'][0] : ''  ?>">
        </div> 
        <div class="col-12">
            <label for="nome-noiva">Nome da noiva:</label>
            <input type="text" name="nome-noiva" class="input-text" value="<?= $meta['_noiva'][0]? $meta['_noiva'][0] : '' ?>">
        </div>
        <div class="col-12">
            <label for="nome-noivo">Nome do noivo:</label>
            <input type="text" name="nome-noivo" class="input-text" value="<?= $meta['_noivo'][0]? $meta['_noivo'][0] : '' ?>">
        </div>
        <div class="col-12">
            <label for="endereco">Endereço do evento:</label>
            <input type="text" name="endereco-evento" class="input-text" value="<?= $meta['_endereco_evento'][0]? $meta['_endereco_evento'][0] : '' ?>">
        </div>
        <div class="col-6">
            <label for="telefone">Telefone:</label>
            <input  id="telefone" type="text" name="telefone" class="input-text mask-phone" value="<?= $meta['_telefone'][0]? $meta['_telefone'][0] : '' ?>">
        </div>

        <?php if($giftlist){
                if($meta['_credito'][0] == 'sim'){
                    ?>
                        <div class="col-12 check-list">
                            <input id="credito" type="checkbox" value="sim" name="credito" checked><label for="">Trocar produtos por crédito na loja?</label>
                        </div>
                    <?php
                }
                else{
                    ?>
                        <div class="col-12 check-list">
                            <input id="credito" type="checkbox" value="sim" name="credito" ><label for="">Trocar produtos por crédito na loja?</label>
                        </div>
                    <?php
                }
        ?>
        <?php
                if($meta['_entrega'][0] == 'sim'){
                    ?>
                    <div class="definir-entrega row justify-content-start">
                            <div class="col-12 radio-list">
                                <input id="entrega" type="checkbox" value="sim" name="entrega" checked><label for="">Deseja que os produtos sejam entregues? (Caso não, deverão ser retirados na loja)</label>
                            </div>
                        </div>
                    <?php
                }
                else{
                    ?>
                        <div class="definir-entrega row justify-content-start">
                            <div class="col-12 radio-list">
                                <input id="entrega" type="checkbox" value="sim" name="entrega"><label for="">Deseja que os produtos sejam entregues? (Caso não, deverão ser retirados na loja)</label>
                            </div>
                        </div>
                    <?php
                }
            
            }else{
                ?>
                    <div class="col-12 check-list">
                        <input id="credito" type="checkbox" value="sim" name="credito" ><label for="">Trocar produtos por crédito na loja?</label>
                    </div>
                    <div class="definir-entrega row justify-content-start">
                         <div class="col-12 radio-list">
                            <input id="entrega" type="checkbox" value="sim" name="entrega"><label for="">Deseja que os produtos sejam entregues? (Caso não, deverão ser retirados na loja)</label>
                        </div>
                    </div>
                <?php
            }
        ?>
           

        <div class="dados-entrega row justify-content-start">
            <div class="col-9">
                <label for="endereco">Endereço de entrega:</label>
                <input type="text" class="input-text entrega-clean" name="endereco-entrega"  value="<?= $meta['_endereco_entrega'][0]? $meta['_endereco_entrega'][0] : '' ?>">
            </div>
            <div class="col-3">
                <label for="numero">Número:</label>
                <input type="text" class="input-text entrega-clean" name="numero"  value="<?= $meta['_numero'][0]? $meta['_numero'][0] : '' ?>">
            </div>  
            <div class="col-6">
                <label for="bairro">Bairro:</label>
                <input type="text" class="input-text entrega-clean" name="bairro"  value="<?= $meta['_bairro'][0]? $meta['_bairro'][0] : '' ?>">
            </div>  
            <div class="col-6">
                <label for="cidade">Cidade:</label>
                <input type="text" class="input-text entrega-clean" name="cidade"  value="<?= $meta['_cidade'][0]? $meta['_cidade'][0] : '' ?>">
            </div> 
            <div class="col-6">
                <label for="cep">CEP:</label>
                <input type="text" class="input-text entrega-clean cep" name="cep"  value="<?= $meta['_cep'][0]? $meta['_cep'][0] : '' ?>">
            </div>
        </div>

        <div class="col-6">
            <?php
                if($giftlist){
                   ?> 
                        <button type="submit" class="button">Mudar Dados</button>
                    <?php
                }else{
                    ?>
                        <button type="submit" class="button">Criar Lista</button>
                    <?php
                }
            ?>
        </div>
    </form>

