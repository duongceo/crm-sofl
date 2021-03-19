<td class="text-center">

    <?php

    if (isset($value['matrix']) && $value['matrix'] != '') {

        echo $value['matrix'];

    } else if ($value['marketer_id'] != 0) {
    	echo $value['marketer_name'];
    } else {

        echo 'UNKNOWN';

    }

    ?>

</td>