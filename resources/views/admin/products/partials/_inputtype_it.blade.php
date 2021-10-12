@if($line['type'] == 'integer')
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
          <small> <label for="{{$line['label_it']}}" class="control-label">{{$line['label_it']}}<BR>( {{ $line['cc_value_sap']  }} )</label></small>
            <input type="number" name="{{$line['id']}}" id="{{$line['label_it']}}"
                   value="<?php if(empty($line['ans_it'])){ echo $line['cc_value_sap'];
                   }else{ echo $line['ans_it']; } ?>" class="form-control">
        </div>
    </div>
@elseif($line['type'] == 'picklist')

   <?php
    $portion =  explode("(",$line['pos_value']);
    $options = explode(";", $portion[0]);
   ?>
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
            <small><label for="{{$line['label_it']}}" class="control-label">{{$line['label_it']}} <BR>( {{ $line['cc_value_sap']  }} )</label></small>
            <select name="{{$line['id']}}" id="{{$line['label_it']}}" class="form-control">
                @for($i=0;$i<count($options);$i++)
                    <?php  $options[$i] =  trim($options[$i]);?>
                <option value="{{ $options[$i] }}" <?php
                    if($line['ans_it'] == null){
                        if($line['cc_value_sap'] == $options[$i]){
                            echo 'selected';
                        }
                    }else{

                        if($line['ans_it'] == $options[$i]){ echo 'selected'; } } ?>>{{ $options[$i] }}</option>
                @endfor
            </select>

        </div>
    </div>
@elseif($line['type'] == 'text')
    <div class="col-lg-2">
        <div class="col-md-12 form-group ">
            <small>  <label for="{{$line['label_it']}}" class="control-label">{{$line['label_it']}}<BR>( {{ $line['cc_value_sap']  }} )</label></small>
            <input type="text" name="{{$line['id']}}" id="{{$line['label_it']}}"
                   value="<?php if(empty($line['ans_it'])){ echo $line['cc_value_sap'];
                   }else{ echo $line['ans_it']; } ?>" class="form-control">
        </div>
    </div>
@endif
