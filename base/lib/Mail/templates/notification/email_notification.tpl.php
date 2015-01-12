<?
$img_dir = 'http://doc.arisface.com/media/mail/notification/';
?>
<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8">
    <link href='http://fonts.googleapis.com/css?family=Raleway:400,600' rel='stylesheet' type='text/css'>
    <title>Arisface</title>

    <style type="text/css">

        /*
           NOTE: CSS should be inlined to avoid having it stripped in certain email clients like GMail.
           Use online tools like http://premailer.dialect.ca/ to inline css easily
        */
        /* General */
        /*@import url(http://fonts.googleapis.com/css?family=Raleway:400,600);*/

        h1 {
            font-size: 24px;
            line-height: 30px;
            font-weight: bold;
            margin: 0 0 8px 0;
            padding: 0;
            color: #252525;
            letter-spacing: -1px;
        }

        h1 span {
            color: #252525;
        }

        /* Hotmail header color bug fix */
        h1 a {
            text-decoration: none;
            color: #3279BB;
        }

        h2 {
            font-size: 18px;
            line-height: 24px;
            font-weight: bold;
            margin: 0 0 10px 0;
            padding: 0;
            color: #252525;
        }

        h2 span {
            color: #252525;
        }

        /* Hotmail header color bug fix */
        h2 a {
            text-decoration: none;
            color: #3279BB;
        }

        a {
            color: rgb(53, 85, 144);
            text-decoration: none;
        }

        p {
            margin: 0 0 12px 0;
            padding: 0;
        }

        i {
            font-style: italic;
        }

        b {
            font-weight: bold;
        }

        img {
            border: none;
        }

        ul {
            list-style-type: disc;
            list-style-position: inside;
            margin: 0 0 12px 0;
            padding: 0 0 0 12px;
        }

        ol {
            list-style-type: decimal;
            list-style-position: inside;
            margin: 0 0 12px 0;
            padding: 0 0 0 12px;
        }

        blockquote {
            margin: 0 20px 12px 20px;
            padding: 0;
        }

        /* Custom classes */

        .wrapper {
            table-layout: fixed;
        }

        /* Hotmail centering bug fix */
        .block {
            display: block;
        }

        /* Layout */

        .content_email p a {
            text-decoration: none;
            color: rgb(53, 85, 144);
            font-weight: bold;
        }

        .view-browser a {
            color: #999999;
            text-decoration: underline;
        }


    </style>

</head>
<body style="width: 100%;
    margin: 0;
    padding: 0;
    background-color: rgb(237, 238, 241);
    font-family: Raleway, sans-serif;
    font-size: 12px;
    line-height: 22px;">

<!-- WRAPPER TABLE -->
<table class="wrapper" cellpadding="0" cellspacing="0" width="100%">
    <tr>
        <td>
            <br>
            <table rules="none" frame="border"
                   style="border-spacing: 0;border-style: solid solid solid solid;
                   border-color: #E4E2E4 #E4E2E4 #E4E2E4 #E4E2E4;
                   border-collapse: collapse;
                   background-color: #ffffff;"
                   align="center" bgcolor="#ffffff" border="0"
                   cellpadding="0" cellspacing="0" width="600">
                <tr>
                    <td class="header" valign="top" style="position: relative">
                        <br><br>
                        <table align="center" cellpadding="0" cellspacing="0" width="540">
                            <tr>
                                <td valign="top" width="260"
                                    style="position: relative; display: inline-block; top: -25px">
                                    <img src="<? echo $img_dir ?>images/logo.png" alt="" class="block" border="0"
                                         width="176">

                                </td>
                                <td width="20">&nbsp;</td>
                                <!-- spacer -->
                                <td class="ourwebsite" align="right" valign="top" width="260">
                                    <a style="color: rgb(53, 85, 144); display: inline-block;font-size: 11px;
                                              font-family: Arial, sans-serif;" href="http://www.arisface.com/">Visitar
                                        Sitio</a>
                                    <?php if ( $activation ): ?>
                                        &nbsp;&nbsp;|&nbsp;&nbsp;
                                        <a style="color: rgb(53, 85, 144); display: inline-block;font-size: 11px;
                                              font-family: Arial, sans-serif;"
                                           href="http://www.arisface.com/<?php echo $user; ?>">Accesar a mi cuenta</a>

                                    <?php endif; ?><br>
                                    <span style="color: #333">Dudas y Soporte: soporte@arisface.com</span>

                                </td>
                            </tr>
                        </table>

                        <div style="background-image: url(<? echo $img_dir ?>images/fondo.png);
                            width: 600px;
                            height: 259px">
                            <div style="width: 300px; top: 50%; float: right; overflow:hidden; padding-top: 56px">
                                <h1 style=" font-weight: 600;color:#fff;
                                font-size: 1.8rem;text-transform: uppercase;">
                                    Un nuevo servicio para consultas y chat en linea
                                </h1>

                                <h3 style="font-size: 1.3rem;color: #c9d9fa !important;">F&aacute;cil y r&aacute;pido
                                    para todos</h3>
                            </div>
                        </div>


                        <!-- ////////////////////////////////// END HEADER /////////////////////////////////////////////// -->

                    </td>
                </tr>
                <tr>
                    <td class="content" valign="top" style="padding: 30px">

                        <!-- ////////////////////////////////// START MAIN CONTENT. ADD MODULES BELOW //////////////////// -->

                        <!-- Module #1 | 1 col, 540px -->
                        <table align="center" cellpadding="0" cellspacing="0" width="540">
                            <tr>

                                <td valign="top" class="content_email">

                                    <strong style="font-family: Arial, sans-serif;font-weight: bold;
                                    color: rgb(96, 96, 96);font-size: 15px;">Bienvenido <?php echo $fullname; ?>
                                        :</strong><br>

                                    <p style="font-family: Arial, sans-serif;color: rgb(96, 96, 96);font-size: 13px;">
                                        <?php echo $mail_content; ?>
                                    </p>

                                    <?php if ( $activation ): ?>
                                        <p style="text-align: left">
                                            <a style="color: rgb(53, 85, 144);"
                                               href="http://arisface.com/<?php echo $user; ?>">Comienza a usar arisface
                                                aqu&iacute;</a>
                                        </p>
                                    <?php endif; ?>

                                </td>

                            </tr>
                        </table>
                        <!-- End Module #1 -->

                        <!-- ////////////////////////////////// END MAIN CONTENT ///////////////////////////////////////// -->

                    </td>
                </tr>
                <tr>
                    <td class="footer" valign="top">

                        <!-- ////////////////////////////////// START FOOTER ///////////////////////////////////////////// -->

                        <img src="<? echo $img_dir ?>images/divider-600x31-2.gif" alt="" class="block" border="0"
                             height="31" width="600">

                        <table align="center" style="background-color: rgb(237,238,241);" cellpadding="0"
                               cellspacing="0"
                               width="600">
                            <tr>
                                <td style="text-align: center;padding-top: 10px" valign="top">

                                    <p style=" margin: 0 !important;font-size: 11px;color: #777;
                                    line-height: 18px;font-family: Arial, sans-serif;">
                                        Copyright:2011 - Todos los derechos reservados Arisface SA de CV</p>

                                    <p style=" margin: 0 !important;font-size: 11px;color: #777;
                                    line-height: 18px;font-family: Arial, sans-serif;">Recibiste este correo por que
                                        acabas de registraste en
                                        <a style="color: rgb(53, 85, 144);" href="http://arisface.com">Arisface</a>
                                    </p>


                                </td>
                            </tr>
                        </table>

                        <!-- ////////////////////////////////// END FOOTER /////////////////////////////////////////////// -->

                    </td>
                </tr>
            </table>

            <!-- ////////////////////////////////// END MAIN CONTENT WRAP //////////////////////////////////// -->

            <br><br><br>

            <!-- ///////////////////////////////////// END NEWSLETTER CONTENT  /////////////////////////////// -->
        </td>
    </tr>
</table>
<!-- END WRAPPER TABLE -->


</body>
</html>

