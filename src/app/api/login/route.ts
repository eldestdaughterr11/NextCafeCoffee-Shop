import { NextRequest, NextResponse } from 'next/server';
import { PrismaClient } from '@prisma/client';

const prisma = new PrismaClient();

export async function POST(req: NextRequest) {
  try {
    const { email, password } = await req.json();

    // Find user in database
    const user = await prisma.user.findUnique({
      where: { email: email }
    });

    if (!user || user.password !== password) {
      return NextResponse.json({ error: 'Invalid email or password' }, { status: 401 });
    }

    // Return user info (except password)
    return NextResponse.json({ 
      message: 'Login successful',
      user: {
        name: user.name,
        email: user.email,
        role: user.role
      }
    }, { status: 200 });
  } catch (error) {
    console.error('Login Error:', error);
    return NextResponse.json({ error: 'Login failed' }, { status: 500 });
  }
}
