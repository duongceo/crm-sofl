<td class="text-center">

    <?php

    if ($value['matrix'] != '') {

        echo $value['matrix'];

    } else if ($value['marketer_id'] != 0) {
    	echo $value['marketer_name'];
    } else {

        echo 'UNKNOWN';

    }

    ?>

</td>