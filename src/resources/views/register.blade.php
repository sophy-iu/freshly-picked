<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <title>商品登録</title>
    <link rel="stylesheet" href="{{ asset('css/register.css') }}">
</head>
<body>
    <header class="header">
        <h1 class="header__logo">mogitate</h1>
    </header>

    <main class="register">
        <h2 class="register__title">商品登録</h2>

        <form class="register-form" action="/products/register" method="POST" enctype="multipart/form-data">
            @csrf

            <label class="register-form__label">商品名 <span>必須</span></label>
            <input class="register-form__input" type="text" name="name" placeholder="商品名を入力">

            <label class="register-form__label">値段 <span>必須</span></label>
            <input class="register-form__input" type="text" name="price" placeholder="値段を入力">

            <label class="register-form__label">商品画像 <span>必須</span></label>
            <input class="register-form__file" type="file" name="image">

            <label class="register-form__label">
                季節 <span>必須</span>
                <strong>複数選択可</strong>
            </label>

            <div class="register-form__seasons">
                @foreach ($seasons as $season)
                    <label>
                        <input type="checkbox" name="seasons[]" value="{{ $season->id }}">
                        {{ $season->name }}
                    </label>
                @endforeach
            </div>

            <label class="register-form__label">商品説明 <span>必須</span></label>
            <textarea class="register-form__textarea" name="description" placeholder="商品の説明を入力"></textarea>

            <div class="register-form__buttons">
                <a class="register-form__back" href="/products">戻る</a>
                <button class="register-form__submit" type="submit">登録</button>
            </div>
        </form>
    </main>
</body>
</html>