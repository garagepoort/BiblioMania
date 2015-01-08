<table>
    <tr>
        <td>Dag:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateDayName, '', array('id'=>$dateDayName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
        <td>Maand:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateMonthName, '', array('id'=>$dateMonthName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
        <td>Jaar:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateYearName, '', array('id'=>$dateYearName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'4')); }}</td>
    </tr>
</table>