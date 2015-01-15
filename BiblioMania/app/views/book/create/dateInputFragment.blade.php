<table>
    <tr>
        <td>Dag:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateDayName, $dateDayValue, array('id'=>$dateDayName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
        <td>Maand:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateMonthName, $dateMonthValue, array('id'=>$dateMonthName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'2')); }}</td>
        <td>Jaar:</td>
        <td style='padding: 0 10px;'>{{ Form::text($dateYearName, $dateYearValue, array('id'=>$dateYearName, 'class' => 'input-xs form-control', 'style' => 'width: 80px', 'maxlength'=>'4')); }}</td>
    </tr>
</table>