<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body style='background-color: hsla(50, 33%, 25%, 0.75);'> <!-- temporario esse style -->
    <div>
        <Form method='POST'>
            <Label>Nome:</label>
            <Input name='L_NOME' id='L_NOME' type='text'></Input><br>
            <Label>Email:</label>
            <Input name='L_EMAIL' id='L_EMAIL' type='email'></Input><br>
            <Label>Senha:</label>
            <Input name='L_SENHA' id='L_SENHA' type='password'></Input><br>
            <Input name='BT_SALVAR' type='submit' value='Acessar'></Input>
        </Form>
    </div>
</body>
</html>