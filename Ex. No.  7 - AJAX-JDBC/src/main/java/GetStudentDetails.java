import java.io.IOException;
import java.io.PrintWriter;
import java.sql.Connection;
import java.sql.DriverManager;
import java.sql.PreparedStatement;
import java.sql.ResultSet;
import jakarta.servlet.ServletException;
import jakarta.servlet.annotation.WebServlet;
import jakarta.servlet.http.HttpServlet;
import jakarta.servlet.http.HttpServletRequest;
import jakarta.servlet.http.HttpServletResponse;

@WebServlet("/GetStudentDetails")
public class GetStudentDetails extends HttpServlet {

    @Override
    protected void doGet(HttpServletRequest request, HttpServletResponse response) throws ServletException, IOException {
        String regNo = request.getParameter("reg_no");
        response.setContentType("text/html");
        PrintWriter out = response.getWriter();

        String jdbcURL = "jdbc:mysql://localhost:3306/studentdb";
        String dbUser = "root";
        String dbPassword = ""; // Use the appropriate password if set in XAMPP

        try {
            // Load MySQL JDBC Driver
            Class.forName("com.mysql.cj.jdbc.Driver");
            Connection conn = DriverManager.getConnection(jdbcURL, dbUser, dbPassword);

            // SQL query to fetch student details
            String query = "SELECT * FROM Students WHERE reg_no = ?";
            PreparedStatement pstmt = conn.prepareStatement(query);
            pstmt.setString(1, regNo);

            ResultSet rs = pstmt.executeQuery();
            if (rs.next()) {
                out.println("<h3>Student Details:</h3>");
                out.println("<p><b>Registration Number:</b> " + regNo + "</p>");
                out.println("<p><b>Name:</b> " + rs.getString("name") + "</p>");
                out.println("<p><b>Department:</b> " + rs.getString("course") + "</p>");
                out.println("<p><b>Email:</b> " + rs.getString("email") + "</p>");
            } else {
                out.println("<p>No student found with the registration number: " + regNo + "</p>");
            }
            conn.close();
        } catch (Exception e) {
            out.println("<p>Error connecting to database: " + e.getMessage() + "</p>");
        }
    }
}
