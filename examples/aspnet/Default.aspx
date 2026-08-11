<%@ Page Language="C#" AutoEventWireup="true" %>
<!DOCTYPE html>
<html lang="ru">
<head runat="server">
    <meta charset="UTF-8" />
    <title>Пример: ASP.NET WebForm-заглушка</title>
</head>
<body>
    <form id="form1" runat="server">
        <div>
            <h1>WP Reload — пример ASP.NET</h1>
            <p>
                Минимальная WebForm-заглушка: демонстрирует директиву
                <code>&lt;%@ Page %&gt;</code>, серверный контрол <code>runat="server"</code>
                и инлайн-код на C#.
            </p>
            <p>
                Текущее время сервера:
                <asp:Label ID="ServerTimeLabel" runat="server" Text="" />
            </p>
        </div>
    </form>
</body>
</html>

<script runat="server">
    protected void Page_Load(object sender, EventArgs e)
    {
        ServerTimeLabel.Text = DateTime.Now.ToString("yyyy-MM-dd HH:mm:ss");
    }
</script>
