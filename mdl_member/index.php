<?php
global $ariacms;

if(!$ariacms->checkUserLogin()){
    echo '<script language="javascript">alert("Vui lòng đăng nhập để sử dụng chức năng.");window.location.href ="/register.html";</script>';
}

//echo "AAAAAAAAA".$ariacms->getParam("task");die;
switch (true) {
	case ($ariacms->getParam("task") == 'chinh-sua-thong-tin'):
		Model::editthongtincanhan();
		break;
	case ($ariacms->getParam("task") == 'ca-nhan'):
		Model::thongtincanhan();
		break;
	case ($ariacms->getParam("task") == 'cap-nhat'):
		Model::capnhatthongtin();
		break;
	case ($ariacms->getParam("task") == 'nhat-ky-hoat-dong'):
		Model::nhatkyhoatdong();
		break;
	case ($ariacms->getParam("task") == 'bai-viet'):
		Model::quanlybaiviet();
		break;
	case ($ariacms->getParam("task") == 'sua-bai-viet'):
		Model::suabaiviet();
		break;
	case ($ariacms->getParam("task") == 'cap-nhat-bai-viet'):
		Model::capnhatbaiviet();
		break;
	case ($ariacms->getParam("task") == 'tao-bai-viet'):
		Model::taobaiviet();
		break;
	case ($ariacms->getParam("task") == 'xoa-bai-viet'):
		Model::xoabaiviet();
		break;
	case ($ariacms->getParam("task") == 'dang-bai'):
		Model::dangbaiviet();
		break;
	case ($ariacms->getParam("task") == 'quan-ly-phan-bien'):
		Model::quanlyphanbien();
		break;
	case ($ariacms->getParam("task") == 'phan-bien'):
		Model::phanbien();
		break;
    case ($ariacms->getParam("task") == 'dong-y-phan-bien'):
        Model::dongy();
        break;
    case ($ariacms->getParam("task") == 'tu-choi-phan-bien'):
        Model::tuchoi();
        break;
	default:
		Model::thongtincanhan();
		break;
}