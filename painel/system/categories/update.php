<?php
if (!class_exists('Login')) :
    header('Location: ../../painel.php');
    die;
endif;
?>

<div class="content form_create">

    <article>

        <header>
            <h1>Atualizar Categoria:</h1>
        </header>

        <?php
          $data = filter_input_array(INPUT_POST, FILTER_DEFAULT);
          $catid = filter_input(INPUT_GET, 'catid', FILTER_VALIDATE_INT);
          if(isset($data['SendPostForm'])):
             $delUlt = array_pop($data);
              require('_models/AdminCategory.class.php');
              $cadastra = new AdminCategory();
             // $cadastra->ExeCreate($data);

                  WSErro($cadastra->getError()[0],$cadastra->getError()[1]);

          else:
              $read = new Read();
              $read->ExeRead('ws_categories', "WHERE category_id = :id", "id={$catid}");
              if(!$read->getResult()):
                  header('Location: painel.php?exe=categories/index&update=false');
                  else:
                  $data = $read->getResult()[0];
                  endif;

        endif;
        ?>


        <form name="PostForm" action="" method="post" enctype="multipart/form-data">


            <label class="label">
                <span class="field">Titulo:</span>
                <input type="text" name="category_title" value="<?php if (isset($data)) echo $data['category_title']; ?>" />
            </label>

            <label class="label">
                <span class="field">Conteúdo:</span>
                <textarea name="category_content" rows="5"><?php if (isset($data)) echo $data['category_content']; ?></textarea>
            </label>

            <div class="label_line">

                <label class="label_small">
                    <span class="field">Data:</span>
                    <input type="text" class="formDate center" name="category_date" value="<?= date('d/m/Y H:i:s'); ?>" />
                </label>

                <label class="label_small left">
                    <span class="field">Seção:</span>
                    <select name="category_parent">
                        <option value="null"> Selecione a Seção: </option>

                        <?php
                        $readSes = new Read();
                       $readSes->ExeRead('ws_categories', "WHERE category_parent IS NULL ORDER BY category_title ASC");
                        if(!$readSes->getResult()):
                            echo"<option disabled=\"disabled\" value=\"null\">Cadastre antes uma seção!</option>";
                        else:
                           foreach($readSes->getResult() as $ses):
                               extract($ses);
                           echo "<option value=\"{$category_id}\" ";
                                if($category_id == $data['category_parent']): echo 'selected="selected"'; endif;
                               echo ">{$category_title}</option>";
                        endforeach;
                        endif;
                        var_dump($readSes);
                        ?>
                    </select>
                </label>
            </div>

            <div class="gbform"></div>

            <input type="submit" class="btn blue" value="Atualizar Categoria" name="SendPostForm" />
        </form>

    </article>

    <div class="clear"></div>
</div> <!-- content home -->