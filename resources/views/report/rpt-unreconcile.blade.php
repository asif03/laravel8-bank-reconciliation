<!DOCTYPE html>
<html>

<head>
  <title>BCPS</title>
</head>

<body>
  <div style="float:left; width:100%; text-align:center;">
    <img src="{{ public_path('bcps.png') }}" alt="BCPS Logo" style="float: left; width: 60px; height: 60px" />
    <h3 style="margin-left: 50px;">Company Name</h3>
  </div>
  <hr style="margin-top: 65px;" />
  <table width="100%" border="0">
    <tr>
      <td colspan="2">
        <h3 style="text-align:center">Reconciliation Report</h3>
      </td>
    </tr>
    <tr>
      <td>
        <p style="text-align:center; font-size: 20px;">Bank Name: {{ $bank_name }}</p>
      </td>
      <td>
        <p style="text-align:center; font-size: 20px;">A/C No.:</p>
      </td>
    </tr>
  </table>

  <table width="100%" border="1">
    @foreach($ledgers as $ledger)
    <tr>
      <td>{{ $ledger->id }}</td>
    </tr>
    @endforeach
  </table>
</body>

</html>