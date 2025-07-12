<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Flea market</title>
</head>

<body>
    <div>
        <p>取引が完了しました。</p>
        <div>
            <p>今回の取引相手はどうでしたか？</p>
            <form action="/transaction/review?transaction_id={{$transaction_id}}" method="post">
                @csrf
                <div class="rating">
                    @for ($i = 1; $i <= 5; $i++)
                        <input type="radio" name="rating" value="{{ $i }}" required> ⭐️
                        @endfor
                </div>
                <button>送信する</button>
            </form>
        </div>
    </div>
</body>

</html>