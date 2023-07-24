<div >
    <h3 style="text-align: center">Damages Document</h3>
    <div>
        <h4>{{$damagesheader[0]->CustomerCode}}</h4>
        <h4>{{$damagesheader[0]->CustomerStoreName}}</h4>

    </div>
    <table border="1" cellspacing="0" width="100%">
        <thead>
         <tr>
             <td>Code</td>
             <td>Product Description</td>
             <td>Quantity </td>
             <td>Notes </td>
         </tr>
        </thead>
        <tbody >
            @foreach($damageslines as $value)
                <tr>
                    <td>{{$value->strPartNumber}}</td>
                    <td>{{$value->strDesc}}</td>
                    <td>{{round($value->Quantity,2)}}</td>
                    <td></td>
                </tr>
                @endforeach
        </tbody>
    </table>
    <br><br>
    <h3>Please note that only 50% of the returned items will be credited.</h3>
    <h5>Signature...............................................................................</h5>
</div>