<?php 

    function output_form_input_text($args){
        $output='';
        if(isset($args) && !empty($args)){
            $output.='<div class="field-single">';
            $output.=sprintf('<label for="%s">%s %s</label>',
                    $args['name'],
                    $args['description'],
                    $args['required']? '<span class="clik-required"> * </span>' : ''
                );
                if($args['type']==='textarea'){
                    $output.=sprintf('<textarea id="%s" name="%s" class="%s" %s>%s</textarea>',
                    $args['name'],
                    $args['name'],
                    $args['class'],
                    $args['required']? 'required' : '',
                    $args['value']
                );
                }else{
                    $output.=sprintf('<input type="%s" id="%s" name="%s" class="%s" value="%s" %s/>',
                    $args['type'],
                    $args['name'],
                    $args['name'],
                    $args['class'],
                    $args['value'],
                    $args['required']? 'required' : ''
                );
                }
              
            $output.='</div>';
        }
        return $output;
    }

    function output_form_select($args){
        $output='';
        $options='';
        if(isset($args) && !empty($args)){
            $output.='<div class="field-single">';
            $output.=sprintf('<label for="%s">%s %s</label>',
                    $args['name'],
                    $args['description'],
                    $args['required']? '<span class="clik-required"> * </span>' : ''
                );
             
            foreach($args['options'] as $key=>$name){
                $options.=sprintf('<option value="%s" %s>%s</option>',
                            $key,
                            $args['value']===$key? 'selected' : '',
                            $name
                        );
            }
            $output.=sprintf('<select id="%s" name="%s" class="%s" %s>%s</select>',
                $args['name'],
                $args['name'],
                $args['class'],
                $args['required']? 'required' : '',
                $options
            );

            $output.='</div>';
        }
        return $output;
    }

    function output_form_radio_check($args){
        $output='';
        $options='';
        if(isset($args) && !empty($args)){
         
            $output.=sprintf('<input type="%s" id="%s" name="%s" class="%s" value="%s" %s/>',
                $args['type'],
                $args['id'],
                $args['name'],
                $args['class'],
                $args['description'],
                $args['value']===$args['description']? 'checked' : ''
            );

            $output.=sprintf('<label for="%s">%s</label>',
                $args['id'],
                $args['description']
        );

        }
        return $output;
    }
