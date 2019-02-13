<?php
    session_start();

	include "./include/variable.php";
	$page_description = "一鍵去信控煙辦";
	$info_title = "Silent Blue";


?>
<!DOCTYPE html>
<html lang="en">
<?php include "./inc_meta.php"; ?>
<body>

<div class="container-fluid pt-4 pb-4">

    <div class="row">
        <div class="col-md-6 col-sm-12">
            <div class="card">
                <div class="card-body">
                    <h3 class="card-title">Silent Blue</h3>
                    <?php
                    $now = time();
                    if(empty($_SESSION['expire']) || $now > $_SESSION['expire'])
                    {
                        session_destroy();
                    ?>
                        <form id="maintainFormId" method="POST" action="send_mail.php">
                            <div class="form-group">
                                <label>我要投訴：</label>
                                <div class="input-group">
                                    <select class="form-control" data-parsley-required="true" name="reportType">
                                        <?php
                                        foreach ($emailList as $value) {
                                            ?>
                                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["subject"]; ?></option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                                <div class="errorHolder"></div>
                                <!--<small class="form-text text-muted">We'll never share your email with anyone else.</small>-->
                            </div>

                            <div class="form-group">
                                <label>日期：</label>
                                <div class='input-group datePicker' data-is-date-time="false" data-is-time-only="false" data-is-range="false" date-is-past="true" date-is-future="false">
                                    <input type="text" class="form-control displayDateRange" autocomplete="off" readonly="true" data-parsley-required="true" />
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    <input type="hidden" class="startDateField" name="reportDate" />
                                </div>
                                <div class="errorHolder"></div>
                            </div>

                            <div class="form-group">
                                <label>時間：</label>
                                <div class='input-group datePicker' data-is-date-time="false" data-is-time-only="true" data-is-range="true" date-is-past="false" date-is-future="false">
                                    <input type="text" class="form-control displayDateRange" autocomplete="off" readonly="true" data-parsley-required="true" />
                                    <div class="input-group-append">
                                    <span class="input-group-text">
                                        <i class="fas fa-calendar-alt"></i>
                                    </span>
                                    </div>
                                    <input type="hidden" class="startDateField" name="reportStartTime" value="08:00" />
                                    <input type="hidden" class="endDateField" name="reportEndTime" value="02:00" />
                                </div>
                                <div class="errorHolder"></div>
                            </div>

                            <div class="form-group">
                                <label>地址：</label>
                                <div class="input-group">
                                    <select class="form-control" data-parsley-required="true" name="address">
                                        <?php
                                        foreach ($addressList as $value) {
                                            ?>
                                            <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]; ?>(<?php echo $value["address"]; ?>)</option>
                                            <?php
                                        };
                                        ?>
                                    </select>
                                </div>
                                <div class="errorHolder"></div>
                            </div>

                            <div class="row">
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>姓：</label>
                                        <div class="input-group" >
                                            <input type="text" class="form-control" data-parsley-required="true" name="lastName" />
                                        </div>
                                        <div class="errorHolder"></div>
                                        <small class="form-text text-muted">請填上<b>中文姓氏</b></small>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="form-group">
                                        <label>稱謂：</label>
                                        <div class="input-group">
                                            <select class="form-control" data-parsley-required="true" name="title">
                                                <?php
                                                foreach ($titleList as $value) {
                                                    ?>
                                                    <option value="<?php echo $value["id"]; ?>"><?php echo $value["name"]; ?></option>
                                                    <?php
                                                };
                                                ?>
                                            </select>
                                        </div>
                                        <div class="errorHolder"></div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label>電郵：</label>
                                <div class="input-group">
                                    <input type="text" class="form-control" data-parsley-required="true" data-parsley-type="email" data-parsley-trigger="focusout" name="email"/>
                                </div>
                                <div class="errorHolder"></div>
                                <small class="form-text text-muted">請填上<strong>正確電郵地址</strong>，因為佢會跟呢個電郵通知你結果 (etc. 有無捉到人)</small>
                                <small class="form-text text-muted">理論上可以填任何email，但gmail經過多次測試已經確定成功</small>
                            </div>

                            <?php /*
                            <div class="form-group form-check">
                                <input type="checkbox" class="form-check-input" id="bcc" name="bcc">
                                <label class="form-check-label" for="bcc">寄份bcc(副本)</label>
                            </div>
                            */ ?>

                            <button type="submit" class="btn btn-primary">傳送</button>
                            <button type="reset" class="btn btn-dark">重設</button>

                        </form>
                    <?php
                    }else{
                    ?>
                        <p>
                            你已經send了<br />
                            60分鐘後再send
                        </p>
                    <?php
                    };
                    ?>

                </div>
            </div>
        </div>
        <div class="col-md-6 col-sm-12">
            <iframe width="100%" height="315" src="https://www.youtube.com/embed/VOUnfYAh-K8" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
        </div>
    </div>


</div>

</body>
<?php include "./inc_js.php"; ?>
</html>