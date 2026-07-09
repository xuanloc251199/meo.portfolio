<table style="width: 100%;">
  @foreach ([
    'Name' => $data['name'],
    'Company' => $data['company'] ?? '',
    'E-mail' => $data['email'],
    'Phone' => $data['phone'],
    'Message' => $data['message'],
  ] as $label => $value)
    @continue($value === '')
    <tr @if ($loop->even) style="background-color: #f8f8f8;" @endif>
      <td style="padding: 10px; border: #e9e9e9 1px solid;"><b>{{ $label }}</b></td>
      <td style="padding: 10px; border: #e9e9e9 1px solid;">{{ $value }}</td>
    </tr>
  @endforeach
</table>
