<?php
class View
{
  static function webInformationFront()
  {
?>
    <section class="content-header">
      <h1>Quản lý thông tin website</h1>
    </section>
<?php
  }
  static function web_information_view()
  {
    include("admin.html.web_information_view.php");
  }
}
?>