# webtech

# How to Push Your Project to GitHub

1. **Open your project folder in your terminal or command prompt.**

2. **Initialize git (if not yet):**
   ```sh
   git init
   ```

3. **Check the status of your files:**
   ```sh
   git status
   ```

4. **Add all your files to staging:**
   ```sh
   git add .
   ```

5. **Commit your changes with a message:**
   ```sh
   git commit -m "Initial commit"
   ```

6. **Create a new repository on GitHub:**
   - Go to https://github.com and click "New repository".
   - Name your repo (e.g., `webtech-website`), then click "Create repository".

7. **Connect your local repo to GitHub:**
   ```sh
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
   ```
   - Replace `YOUR_USERNAME` and `YOUR_REPO_NAME` with your GitHub username and the repo name you created.

8. **Set your branch to main (if needed):**
   ```sh
   git branch -M main
   ```

9. **Push your code to GitHub:**
   ```sh
   git push -u origin main
   ```

10. **Check your repository on GitHub.**
    - Go to your repo URL and you should see your files online.

**Tips:**
- If you change files, repeat steps 3, 4, 5, and 9 to update your GitHub repo.
- If asked for username/password, use your GitHub credentials or a personal access token.

# Step-by-step kung paano mag-push ng project sa GitHub (Tagalog)

1. **Buksan ang iyong project folder gamit ang terminal o command prompt.**

2. **I-initialize ang git (gawin lang ito kung wala pang `.git` folder):**
   ```sh
   git init
   ```

3. **Tingnan ang status ng mga files mo:**
   ```sh
   git status
   ```

4. **I-add lahat ng files para isama sa commit:**
   ```sh
   git add .
   ```

5. **Gumawa ng commit na may message:**
   ```sh
   git commit -m "Initial commit"
   ```

6. **Gumawa ng bagong repository sa GitHub:**
   - Pumunta sa https://github.com at i-click ang "New repository".
   - Pangalanan ang repo (hal. `webtech-website`), tapos i-click ang "Create repository".

7. **I-connect ang local repo mo sa GitHub:**
   ```sh
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
   ```
   - Palitan ang `YOUR_USERNAME` at `YOUR_REPO_NAME` ng username at pangalan ng repo mo sa GitHub.

8. **I-set ang branch name sa main (kung kinakailangan):**
   ```sh
   git branch -M main
   ```

9. **I-push ang code mo sa GitHub:**
   ```sh
   git push -u origin main
   ```

10. **Tingnan ang repository mo sa GitHub.**
    - Pumunta sa repo URL mo at makikita mo na ang files mo online.

**Tips:**
- Kapag may binago ka, ulitin lang ang steps 3, 4, 5, at 9 para ma-update ang GitHub repo mo.
- Kung hihingi ng username/password, gamitin ang GitHub credentials mo o personal access token.

**Ano ibig sabihin ng error na ito?**

Kapag nakakita ka ng error na  
`error: failed to push some refs to 'https://github.com/lemonthegreat09/webtech.git'`  
ibig sabihin ay hindi mo na-push ang code mo sa GitHub repository. Madalas, ito ay dahil:

- **May laman na ang remote repository** (halimbawa, may README.md o .gitignore na naunang na-push sa GitHub).
- **May conflict** sa branch na gusto mong i-push.
- **Na-add mo nang dalawang beses ang remote** (tingnan mo, mali ang command mo: `git remote add origin ... ...` dapat isa lang).

**Paano ayusin:**

1. **Tanggalin ang maling remote kung naulit:**
   ```sh
   git remote remove origin
   ```

2. **I-add ulit ang tamang remote (isa lang):**
   ```sh
   git remote add origin https://github.com/YOUR_USERNAME/YOUR_REPO_NAME.git
   ```

3. **Kung may laman na ang repo sa GitHub, i-pull mo muna:**
   ```sh
   git pull origin main --allow-unrelated-histories
   ```

4. **Tapos, push mo ulit:**
   ```sh
   git push -u origin main
   ```

**Summary:**  
Ang error na ito ay karaniwan kapag may laman na ang GitHub repo mo bago ka mag-push, o mali ang pag-add ng remote. Sundin ang steps sa taas para maayos.
