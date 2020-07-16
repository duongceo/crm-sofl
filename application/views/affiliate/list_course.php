<?php if (isset($progressType)) { ?>

    <div class="container">

        <div class="row">

            <div class="col-md-10 col-md-offset-1">

                <h1 class="text-center text-uppercase red margintop20 marginbottom20"> <?php echo $progressType ?> </h1>

                <?php foreach ($progress as $team) { ?>

                    <div class="row">

                        <div class="col-md-4 text-right text-uppercase margintop5">

                            <?php echo $team['name'] . ' (' . $team['count'] . '/' . $team['kpi'] . ') (' . $team['type'] . ')'; ?> 

                        </div>

                        <div class="col-md-6">

                            <div class="progress skill-bar ">

                                <div class="progress-bar <?php echo getProgressBarClass($team['progress']); ?>" role="progressbar" aria-valuenow="<?php echo $team['progress'] ?>" aria-valuemin="0" aria-valuemax="100">

                                    <span class="skill text-uppercase"> 

                                        <?php // echo $marketer['name'] . ' (' . $marketer['totalC3'] . '/' . $marketer['targets'] . ')'; ?> 

                                        <?php echo $team['progress'] ?>% 

                                    </span>

                                </div>

                            </div>

                        </div>

                    </div>

                <?php } ?>

            </div>

        </div>

    </div>

<?php } ?>



<div class="row">

    <div class="col-md-10 col-md-offset-1">

<!--        <h3 class="text-center marginbottom20"> <?php echo $titleListContact; ?> <sup> <span class="badge bg-red"> <?php echo $total_contact; ?> </span> </sup></h3>-->

    </div>

</div>

<form action="<?php echo base_url() . $actionForm; ?>" method="POST" id="action_contact" 

      class="form-inline <?php echo ($total_contact > 0) ? '' : 'empty'; ?>">

    <?php $this->load->view('common/content/filter'); ?>

    <?php if ($this->total_paging > 0) { ?>

        <div class="pagination">

            <?php echo isset($pagination) ? $pagination : ''; ?>

        </div>

        <div class="number_paging">

            <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' sản phẩm'; ?>

        </div>

        <table class="table table-bordered table-expandable table-striped list_contact list_contact_2 table-fixed-head">
            <thead>
                <tr>
                    <th></th>
                    <th>
                        Khóa học
                    </th>
                    <th>
                        Giá niêm yết
                    </th>
                    <th>
                        Giá sale
                    </th>
                    <th>
                        Link
                    </th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (isset($contacts)) {
                    foreach ($contacts as $key => $value) {
                        ?>
                        <tr>
                            <td>
                                <img style="width:100%" src="<?php echo $value['image']; ?>">
                            </td>
                            <td class="center tbl_course_code"> 
                                <b><?php echo $value['name']; ?> 
                                </b>
                            </td>
                            <td class="center tbl_course_code"> 
                                <span><?php echo $value['price_root2']; ?> 
                                </span>
                            </td>
                            <td class="center tbl_course_code"> 
                                <span><?php echo $value['price_sale']; ?> 
                                </span>
                            </td>
                            <td>
                                <button class="btn btn-success get_link" 
                                        slug="<?php echo $value['slug']; ?>"
                                        course_code="<?php echo $value['course_code'] ?>"
                                        javascript:void(0) >Lấy link</button>
                            </td>
                        </tr>
                        <?php
                    }
                }
                ?>

            </tbody>

        </table>

        <div class="number_paging"> 

                <?php echo 'Hiển thị ' . $this->begin_paging . ' - ' . $this->end_paging . ' của ' . $this->total_paging . ' sản phẩm'; ?>

        </div>

        <div class="pagination">

    <?php echo isset($pagination) ? $pagination : ''; ?>

        </div>

            <?php
        }
        ?>

<?php
if (isset($informModal)) {

    foreach ($informModal as $modal) {

        //  $this->load->view('manager/modal/divide_contact');

        $this->load->view($modal);
    }
}
?>

</form>



    <?php
    if (isset($outformModal)) {

        foreach ($outformModal as $modal) {

            //  $this->load->view('manager/modal/divide_contact');

            $this->load->view($modal);
        }
    }
    ?>

<?php

//$this->load->view('manager/modal/divide_one_contact');

