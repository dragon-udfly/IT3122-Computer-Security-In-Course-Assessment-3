# Computer Security Assessment Repository 🔒🛡️
- Course: IT3122 Computer Security
- Related: In-Course Assessment - 3
  <br>
A comprehensive academic assessment project (`IT3122 - Computer Security`) demonstrating common web vulnerabilities (SQL Injection, Cross-Site Scripting, and CSRF) alongside their secure counterparts and mitigation strategies.

---

## 📂 Repository Structure

```text
IT3122-Computer-Security-In-Course-Assessment-3/
│
├── attacker_site.html         # Simulated malicious attacker website for CSRF
├── attacker_site1.html        # Secondary payload/exploit simulation page
│
├── csrf_vulnerable.php        # Implementation vulnerable to Cross-Site Request Forgery
├── csrf_secure.php            # Secure implementation with anti-CSRF tokens/validation
│
├── sql_injection_vulnerable.php # Implementation vulnerable to SQL Injection (SQLi)
├── sql_injection_solution.php   # Secure implementation using prepared statements
│
├── xss_dom_vulnerable.php     # DOM-based XSS vulnerable implementation
├── xss_dom_secure.php         # Secure DOM-based XSS mitigation
│
├── xss_reflected_vulnerable.php # Reflected XSS vulnerable implementation
├── xss_reflected_secure.php     # Secure reflected XSS mitigation (output encoding)
│
├── xss_stored_vulnerable.php    # Stored XSS vulnerable implementation
├── xss_stored_secure.php        # Secure stored XSS implementation
│
├── security_db.sql            # Initial database schema and tables
└── security_db_backup.sql     # Database backup/dump for testing
```
## 🚀 Key Topics & Vulnerabilities Addressed
- SQL Injection (SQLi): Demonstrates how raw, unsanitized user inputs interact with backend queries and how parameterized queries/prepared statements neutralize the threat (sql_injection_vulnerable.php vs sql_injection_solution.php).
- Cross-Site Scripting (XSS):
- Reflected XSS: Unsanitized parameters reflected directly in the response.
- Stored XSS: Malicious scripts persisted in the database and rendered back to users.
- DOM-based XSS: Client-side script vulnerabilities handling insecure DOM sources.
- Cross-Site Request Forgery (CSRF): Illustrates unauthorized command transmissions from a trusted user facilitated by external malicious domains (attacker_site.html / csrf_vulnerable.php vs csrf_secure.php).
