<table style="background-color:white;margin-bottom:15px;padding:5px">
    <tr>


        <td style="display: block">


        </td>
        <td width="1%" style="padding:10px">
            <p style="font-size: 12px;color: rgb(119, 119, 119);padding: 0;margin: 0;text-align: left;">
                Today's Date
            </p>
            <p style="padding: 0;margin: 0;">
                <?php 
                                date_default_timezone_set('Africa/Tunisia');
        
                                $today = date('Y-m-d');
                                echo $today;


                                ?>
            </p>
        </td>
        <td width="4%">
            <button class="btn-label" disabled
                style="width:80%;height:50px;display: flex;justify-content: center;align-items: center;"><img
                    src="../images/calendar.svg" width="70%"></button>
        </td>
    </tr>
</table>