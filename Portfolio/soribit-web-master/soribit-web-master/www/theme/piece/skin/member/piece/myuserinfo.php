<div class="content join info">
    <h2 class="list_title join">회원정보</h2>
    <div class="info_contents">
        <ul class="info_contents-list">
            <li>
                <span>이메일</span>
                <p><?php echo $member['mb_id'];?></p>
            </li>
            <li>
                <span>이름</span>
                <p><?php echo $member['mb_name'];?></p>
            </li>
            <li>
                <span>연락처</span>
                <p><?php echo $member['mb_tel'];?></p>
            </li>
            <li>
                <span>등급</span>
                <!-- 아이콘은 .type에 클래스명 붙여주세요 -->
                <!-- common, company, organization, protector, impaired -->
                <p class="type common <?php echo checkMemberLevel($member['mb_1'])['class'];?>"><?php echo checkMemberLevel($member['mb_1'])['person'];?></p>
            </li>
        </ul>
        <div class="certify">
            <span>장애인등록증/사업자등록증 인증</span>
            <!-- 인증 없을 시 -->
            <?php if(!$member['mb_2']){ ?>
            <p>없음</p>
            <?php } else {?>
            <!-- 인증 했을 때 - 이미지 파일 -->
            <div class="certify_image">
                <img src="<?php echo getMemberUploadImg($member['mb_2'])?>" alt="<?php echo $member['mb_2']?>">
            </div>
            <!-- 인증 했을 때 - pdf -->
            <div class="certify_file"><?php echo $member['mb_2']?></div>
            <?php }?>
        </div>
        <a href="<?php echo G5_BBS_URL.'/register_form.php?w=u'?>" class="btn_info_modify">회원정보 수정</a>
    </div>
</div>