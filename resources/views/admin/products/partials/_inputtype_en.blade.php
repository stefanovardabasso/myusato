@if($line['type'] == 'integer')
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
         <small>  <label for="{{$line['label_en']}}" class="control-label">{{$line['label_en']}}<BR>( {{ $line['cc_value_sap']  }} )</label></small>
            <input type="number" name="{{$line['id']}}" id="{{$line['label_en']}}"
                   value="<?php if(empty($line['ans_en'])){ echo $line['cc_value_sap'];
                   }else{ echo $line['ans_en']; } ?>" class="form-control">
        </div>
    </div>
@elseif($line['type'] == 'picklist')
    <?php
    $portion =  explode("(",$line['pos_value']);
     if(count($portion) == 2){
        $options = explode(";", $portion[1]);
    }else{
        $options = explode(";", $portion[0]);
    }
 ?>
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
            <small>   <label for="{{$line['label_en']}}" class="control-label">{{$line['label_en']}}<BR> ( {{ $line['cc_value_sap']  }} )</label></small>
            <select name="{{$line['id']}}" id="{{$line['label_en']}}" class="form-control">
                @for($i=0;$i<count($options);$i++)
                    <?php if(strpos($options[$i], ")")){
                        $options[$i] =  str_replace(")","",$options[$i]);
                        $options[$i] =  trim($options[$i]);

                    }  ?>
                    <option value="{{ $options[$i] }}" <?php if($line['ans_en'] == null){ if($line['cc_value_sap'] == $options[$i]){ echo 'selected'; } }else{ if($line['ans_en'] == $options[$i]){ echo 'selected'; } } ?>>{{ $options[$i] }}</option>
                @endfor
            </select>

        </div>
    </div>
@elseif($line['type'] == 'text')
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
            <small>  <label for="{{$line['label_en']}}" class="control-label">{{$line['label_en']}}<BR>( {{ $line['cc_value_sap']  }} )</label></small>
            <input type="text" name="{{$line['id']}}" id="{{$line['label_en']}}"
                   value="<?php if(empty($line['ans_en'])){ echo $line['cc_value_sap'];
                   }else{ echo $line['ans_en']; } ?>" class="form-control">
        </div>
    </div>
@endif
